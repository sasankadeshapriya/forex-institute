@extends('client.layouts.main')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <!-- Section Header with Progress Bar -->
        <div class="section-header row align-items-center">
            <div class="col-12" style="padding-left: 0px; padding-right: 0px;">
                <h1>Bitcoin Trading Course</h1>
                <!-- Progress Bar (Visible on all screen sizes) -->
                <div class="mt-2">
                    <div class="progress" style="height: 12px; border-radius: 6px;">
                        <div class="progress-bar" role="progressbar" style="width: 60%; background-color: #6777ef;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted mt-1 d-block">60% completed</small>
                </div>
            </div>
        </div>

        <div class="section-body">
            <!-- Mobile Dropdown -->
            <div class="d-md-none mb-3">
                <select id="mobileCourseSelector" class="form-control">
                    <option value="intro">Introduction to Bitcoin</option>
                    <option value="wallet">Setting Up a Wallet</option>
                    <option value="trading">Trading Strategies</option>
                    <option value="risk">Risk Management</option>
                    <option value="summary">Course Summary</option>
                </select>
            </div>

            <div class="row">
                <!-- Sidebar: Course Content -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="list-group" id="courseContent">
                        <button class="list-group-item list-group-item-action active" data-content="intro">
                            <span>Introduction to Bitcoin</span>
                            <span class="icon-circle"><i class="icon ion-ios-arrow-forward"></i></span>
                        </button>
                        <button class="list-group-item list-group-item-action" data-content="wallet">
                            <span>Setting Up a Wallet</span>
                            <span class="icon-circle"><i class="icon ion-ios-arrow-forward"></i></span>
                        </button>
                        <button class="list-group-item list-group-item-action" data-content="trading">
                            <span>Trading Strategies</span>
                            <span class="icon-circle"><i class="icon ion-ios-arrow-forward"></i></span>
                        </button>
                        <button class="list-group-item list-group-item-action" data-content="risk">
                            <span>Risk Management</span>
                            <span class="icon-circle"><i class="icon ion-ios-arrow-forward"></i></span>
                        </button>
                        <button class="list-group-item list-group-item-action" data-content="summary">
                            <span>Course Summary</span>
                            <span class="icon-circle"><i class="icon ion-ios-arrow-forward"></i></span>
                        </button>
                    </div>
                </div>

                <!-- Main Display -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body position-relative" id="courseContentDisplay">
                            <a href="#" class="mark-complete">Mark as Complete</a>
                            <h4>Introduction to Bitcoin</h4>
                            <p>Learn what Bitcoin is and how it works in the digital economy.</p>
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
    .list-group-item:hover {
        border-color: #6777ef;
        background-color: #f3f6ff;
        color: #6777ef;
    }
    .list-group-item:hover .icon-circle {
        background-color: #6777ef;
        color: #fff;
    }
    .list-group-item.active {
        background-color: #f3f6ff;
        border-color: #6777ef !important;
        color: #6777ef !important;
    }
    .list-group-item.active .icon-circle {
        background-color: #6777ef;
        color: white;
    }
    .list-group-item:focus {
        outline: none;
        box-shadow: none;
    }
    .mark-complete {
        position: absolute;
        top: 10px;
        right: 25px;
        color: #6777ef;
        font-size: 14px;
        text-decoration: none;
    }
</style>
@endpush

@push('scripts')
<script>
    const contentMap = [
        {
            key: 'intro',
            title: "Introduction to Bitcoin",
            type: "text",
            content: "Learn what Bitcoin is and how it works in the digital economy."
        },
        {
            key: 'wallet',
            title: "Setting Up a Wallet",
            type: "video",
            content: "https://drive.google.com/file/d/EXAMPLE_VIDEO_ID/preview"
        },
        {
            key: 'trading',
            title: "Trading Strategies",
            type: "pdf",
            content: "path/to/your.pdf"
        },
        {
            key: 'risk',
            title: "Risk Management",
            type: "file",
            content: "path/to/your.zip"
        },
        {
            key: 'summary',
            title: "Course Summary",
            type: "text",
            content: "Recap of everything you've learned and next steps."
        }
    ];

    let currentIndex = 0;
    const displayContent = (index) => {
        const item = contentMap[index];
        let html = `<a href="#" class="mark-complete">Mark as Complete</a><h4>${item.title}</h4>`;
        switch (item.type) {
            case 'video':
                html += `<iframe src="${item.content}" width="100%" height="400"></iframe>`;
                break;
            case 'pdf':
                html += `<embed src="${item.content}" type="application/pdf" width="100%" height="600px">`;
                break;
            case 'file':
                html += `<p><a href="${item.content}" download class="btn btn-primary">Download File</a></p>`;
                break;
            default:
                html += `<p>${item.content}</p>`;
        }
        document.getElementById('courseContentDisplay').innerHTML = html;
    };

    document.querySelectorAll('#courseContent button').forEach((btn, idx) => {
        btn.addEventListener('click', () => {
            currentIndex = idx;
            updateActiveButton();
            displayContent(currentIndex);
        });
    });

    document.getElementById('mobileCourseSelector').addEventListener('change', function () {
        currentIndex = contentMap.findIndex(item => item.key === this.value);
        updateActiveButton();
        displayContent(currentIndex);
    });

    document.getElementById('nextBtn').addEventListener('click', () => {
        if (currentIndex < contentMap.length - 1) {
            currentIndex++;
            updateActiveButton();
            displayContent(currentIndex);
        }
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateActiveButton();
            displayContent(currentIndex);
        }
    });

    function updateActiveButton() {
        document.querySelectorAll('#courseContent button').forEach(btn => btn.classList.remove('active'));
        const btns = document.querySelectorAll('#courseContent button');
        if (btns[currentIndex]) btns[currentIndex].classList.add('active');
        document.getElementById('mobileCourseSelector').value = contentMap[currentIndex].key;
    }

    displayContent(currentIndex);
</script>
@endpush
