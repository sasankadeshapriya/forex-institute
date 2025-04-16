@extends('client.layouts.main')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <!-- Section Header with Progress Bar -->
        <div class="section-header row align-items-center">
            <div class="col-12" style="padding-left: 0px; padding-right: 0px;">
                <h1>{{ $course->name }}</h1> <!-- Course Title -->
                <div class="mt-2">
                    <!-- Progress Bar -->
                    <div class="progress" style="height: 12px; border-radius: 6px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted mt-1 d-block">{{ number_format($progress, 2) }}% completed</small>
                </div>
            </div>
        </div>

        <div class="section-body">
            <!-- Mobile Dropdown -->
            <div class="d-md-none mb-3">
                <select id="mobileCourseSelector" class="form-control">
                    @foreach($contents as $content)
                        <option value="{{ $content->id }}" {{ $content->id == $nextContent->id ? 'selected' : '' }}>
                            {{ $content->heading }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <!-- Sidebar: Course Content -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="list-group" id="courseContent">
                        @foreach($contents as $content)
                            <button class="list-group-item list-group-item-action
                            @if (in_array($content->id, $completedContentIds))
                                bg-completed
                            @endif
                            @if ($content->id == $nextContent->id) active @endif"
                            data-content="{{ $content->id }}">
                                <span>{{ $content->heading }}</span>
                                <span class="icon-circle"><i class="icon ion-ios-arrow-forward"></i></span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Main Display -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body position-relative" id="courseContentDisplay">
                            <a href="#" class="mark-complete" id="markCompleteBtn">Mark as Complete</a>
                            <h4 id="contentTitle">{{ $nextContent->heading }}</h4>
                            <p id="contentDescription">{{ $nextContent->content }}</p>
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #d79a5b2e;
        border-radius: 6px;
        margin-bottom: 10px;
        background-color: #fff;
        padding: 12px 16px;
        font-size: 15px;
        color: #333;
        transition: all 0.2s ease-in-out;
    }
    .list-group-item .icon-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #eee;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    .list-group-item.active {
        background-color: #f3f6ff;
        border-color: #6777ef !important;
        color: #6777ef !important;
    }
    .bg-completed {
        background-color: #fbf8f4 !important;
    }
    .mark-complete {
        position: absolute;
        top: 10px;
        right: 25px;
        color: #6777ef;
        font-size: 14px;
        text-decoration: none;
    }

    .list-group-item:focus {
        outline: none;
        box-shadow: none;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make sure contentMap is available
    let contentMap = @json($contents); // Pass this correctly from Laravel to JavaScript
    let currentIndex = @json($nextContent->id) - 1; // Set to next content's index (use the correct last completed index)

    // Function to display the content in the content area
    const displayContent = (index) => {
        const content = contentMap[index];
        document.getElementById('contentTitle').innerHTML = content.heading;
        document.getElementById('contentDescription').innerHTML = content.content;

        // Mark content as completed when clicked
        document.getElementById('markCompleteBtn').addEventListener('click', () => {
            markContentComplete(content.id);
        });
    };

    // Mark the content as complete
    const markContentComplete = (contentId) => {
        fetch(`/entrolled-courses/${{{ $course->id }}}/mark-complete/${contentId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(response => response.json())
          .then(data => {
            alert("Content marked as complete!");

            // After marking complete, move to the next content
            currentIndex = findNextContentIndex(contentId); // Find the next content
            displayContent(currentIndex); // Refresh content
            updateActiveButton(); // Update the active button in the sidebar
        });
    };

    // Find the next content index based on the completed content
    const findNextContentIndex = (completedContentId) => {
        // Find the index of the current completed content and move to the next one
        let nextContentIndex = contentMap.findIndex(content => content.id === completedContentId) + 1;

        // If there is no next content, stay at the last content
        if (nextContentIndex >= contentMap.length) {
            nextContentIndex = contentMap.length - 1;
        }

        return nextContentIndex;
    };

    // Update the active content in sidebar
    const updateActiveButton = () => {
        document.querySelectorAll('#courseContent button').forEach(btn => btn.classList.remove('active'));
        const btns = document.querySelectorAll('#courseContent button');
        if (btns[currentIndex]) {
            btns[currentIndex].classList.add('active');
        }
    };

    // Next and Previous Button Navigation
    document.getElementById('nextBtn').addEventListener('click', () => {
        if (currentIndex < contentMap.length - 1) {
            currentIndex++;
            displayContent(currentIndex);
            updateActiveButton(); // Update the active button in the sidebar
        }
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            displayContent(currentIndex);
            updateActiveButton(); // Update the active button in the sidebar
        }
    });

    // Sidebar navigation for content click
    document.querySelectorAll('#courseContent button').forEach((btn, index) => {
        btn.addEventListener('click', () => {
            currentIndex = index;
            displayContent(currentIndex);
            updateActiveButton(); // Update active button
        });
    });

    // Initialize the page load by displaying the first content and setting active button
    displayContent(currentIndex); // Initial content display
    updateActiveButton(); // Set the active content in the sidebar
});

</script>
@endpush
