@extends('client.layouts.main')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header row align-items-center">
      <div class="col-12 px-0">
        <h1>{{ $course->name }}</h1>
        <div class="mt-2">
          <div class="progress" style="height:12px;border-radius:6px;">
            <div
              id="progressBar"
              class="progress-bar"
              role="progressbar"
              style="width:{{ $progress }}%;"
              aria-valuenow="{{ $progress }}"
              aria-valuemin="0"
              aria-valuemax="100"></div>
          </div>
          <small id="progressText" class="text-muted d-block mt-1">
            {{ number_format($progress,2) }}% completed
          </small>
        </div>
      </div>
    </div>

    <div class="section-body">
      {{-- Mobile selector --}}
      <div class="d-md-none mb-3">
        <select id="mobileCourseSelector" class="form-control">
          @foreach($contents as $c)
            <option value="{{ $c->id }}" {{ $c->id === $nextContent->id ? 'selected' : '' }}>
              {{ $c->heading }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="row">
        {{-- Sidebar --}}
        <div class="col-md-3 d-none d-md-block">
          <div class="list-group" id="courseContent">
            @foreach($contents as $c)
              <button
                class="list-group-item list-group-item-action
                  @if(in_array($c->id, $completedContentIds)) bg-completed @endif
                  @if($c->id === $nextContent->id) active @endif"
                data-content="{{ $c->id }}">
                <span>{{ $c->heading }}</span>
                <span class="icon-circle"><i class="icon ion-ios-arrow-forward"></i></span>
              </button>
            @endforeach
          </div>
        </div>

        {{-- Main Display --}}
        <div class="col-md-9">
          <div class="card">
            <div class="card-body position-relative" id="courseContentDisplay">
              {{-- Mark as Complete now posts a form --}}
              <form
                action="{{ route('entrolled-courses.mark-complete', [
                  'entrolled_course' => $course->id,
                  'contentId'        => $nextContent->id
                ]) }}"
                method="POST"
                style="display:inline;"
              >
                @csrf
                <button
                  type="submit"
                  class="mark-complete btn btn-link p-0"
                  style="position:absolute; top:10px; right:25px;"
                >Mark as Complete</button>
              </form>

              <h4 id="contentTitle">{{ $nextContent->heading }}</h4>
              <div id="contentDescription"></div>
            </div>

            <div class="card-footer d-flex justify-content-between">
              <button class="btn btn-outline-primary" id="prevBtn">Previous</button>
              <button class="btn btn-outline-primary" id="nextBtn">Next</button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css">
<style>
  .list-group-item {
    display:flex; justify-content:space-between; align-items:center;
    border:1px solid #d79a5b2e; border-radius:6px; margin-bottom:10px;
    background:#fff; padding:12px 16px; font-size:15px; color:#333;
    transition:all .2s;
  }
  .list-group-item .icon-circle {
    width:30px; height:30px; border-radius:50%; background:#eee;
    display:flex; align-items:center; justify-content:center; font-size:16px;
  }
  .list-group-item.active {
    background:#f3f6ff!important; border-color:#6777ef!important; color:#6777ef!important;
  }
  .bg-completed { background-color:#fbf8f4!important; }
  .mark-complete {
    position:absolute; top:10px; right:25px; color:#6777ef;
    font-size:14px; text-decoration:none;
  }
  .list-group-item:focus { outline:none; box-shadow:none; }
  button:disabled { opacity:0.5; cursor:not-allowed; }
</style>
@endpush

@php
  // Build a lightweight JS array with file sizes
  use Illuminate\Support\Facades\Storage;
  $jsContents = $contents->map(function($c){
      return [
          'id'           => $c->id,
          'heading'      => $c->heading,
          'content'      => $c->content,
          'content_type' => $c->content_type,
          'file_size'    => in_array($c->content_type, ['file','pdf'])
                              ? Storage::disk('private')->size($c->content)
                              : null,
      ];
  });
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const contents       = @json($jsContents);
  const totalCount     = contents.length;
  let   completedCount = @json(count($completedContentIds));
  let   currentIndex   = contents.findIndex(c => c.id === @json($nextContent->id));

  const filename = path => path.split('/').pop();
  const driveId  = url  => (url.match(/\/d\/([^\/]+)/)||[])[1] || null;

  // render content area
  function display(i) {
    const c = contents[i];
    document.getElementById('contentTitle').innerText = c.heading;

    if (!c || !c.content) {
      document.getElementById('contentDescription')
              .innerHTML = '<p>Content could not be loaded.</p>';
    } else {
      let html = '';
      switch(c.content_type) {
        case 'video':
          const vid = driveId(c.content);
          html = vid
            ? `<div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;">
                 <iframe
                   src="https://drive.google.com/file/d/${vid}/preview"
                   style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                   allow="autoplay; encrypted-media"
                   allowfullscreen
                   sandbox="allow-scripts allow-same-origin"></iframe>
               </div>`
            : '<p>Invalid video URL.</p>';
          break;
        case 'text':
          html = `<div>${c.content}</div>`;
          break;
        case 'pdf':
          const pdf = filename(c.content);
          html = `<p><a href="/file-download/${pdf}" download>Download PDF</a></p>
                  <embed src="/file-stream/${pdf}"
                         type="application/pdf"
                         width="100%" height="600px"/>`;
          break;
        case 'file':
          const f = filename(c.content),
                sz = c.file_size ? ` (${c.file_size} bytes)` : '';
          html = `<p>File: ${f}${sz} — <a href="/file-download/${f}" download>Download</a></p>`;
          break;
      }
      document.getElementById('contentDescription').innerHTML = html;
    }

    refreshControls();
  }

  function refreshActive() {
    document.querySelectorAll('#courseContent button')
      .forEach(b => b.classList.remove('active'));
    const btns = document.querySelectorAll('#courseContent button');
    if (btns[currentIndex]) btns[currentIndex].classList.add('active');
  }
  function refreshControls() {
    document.getElementById('prevBtn').disabled = (currentIndex === 0);
    document.getElementById('nextBtn').disabled = (currentIndex === totalCount - 1);
  }

  // prev/next
  document.getElementById('prevBtn').onclick = () => {
    if (currentIndex>0) { currentIndex--; display(currentIndex); refreshActive(); }
  };
  document.getElementById('nextBtn').onclick = () => {
    if (currentIndex<totalCount-1) { currentIndex++; display(currentIndex); refreshActive(); }
  };

  // sidebar click
  document.querySelectorAll('#courseContent button').forEach((btn,i) => {
    btn.onclick = () => { currentIndex=i; display(i); refreshActive(); };
  });

  // mobile selector sync
  document.getElementById('mobileCourseSelector').onchange = function(){
    const selId = +this.value,
          idx   = contents.findIndex(c=>c.id===selId);
    if (idx>=0){ currentIndex=idx; display(idx); refreshActive(); }
  };

  // init
  display(currentIndex);
  refreshActive();
});
</script>
@endpush
