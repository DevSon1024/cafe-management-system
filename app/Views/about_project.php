<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .team-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    .team-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 4px solid var(--primary-color);
    }
</style>

<div class="container">
    <div class="text-center my-5">
        <h1 class="display-4 text-gradient">About The Project</h1>
        <p class="lead text-muted">Details about the "Cafe Management System" project.</p>
    </div>

    <!-- Project Details Card -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-file-earmark-text-fill me-2"></i>Project Details</h4>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Project Title:</strong>
                    <span>Cafe Management System</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Subject:</strong>
                    <span>Web Development with PHP</span>
                </li>
                 <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>University/College:</strong>
                    <span>Udhna Citizen College</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Faculty Name:</strong>
                    <span>Prof. not for now</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Development Team Section -->
    <div class="text-center mb-5">
        <h2 class="display-5">Development Team</h2>
        <p class="text-muted">The individuals who brought this project to life.</p>
    </div>

    <div class="row">
        <!-- Team Member 1 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-center team-card h-100">
                <div class="card-body">
                    <img src="https://i.ibb.co/zh66fdzJ/Gemini-AI-Generated-Image-6bxr1h6bxr1h6bxr.png" class="rounded-circle mb-3 team-img" alt="Team Member 1">
                    <h5 class="card-title">Devendra Prabhakar Sonawane</h5>
                    <p class="text-muted">Roll No: 2548008</p>
                    <p class="card-text"><strong>Contribution:</strong> Project Lead, Backend Development (PHP, CodeIgniter), Database Management.</p>
                </div>
            </div>
        </div>

        <!-- Team Member 2 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-center team-card h-100">
                <div class="card-body">
                    <img src="https://placehold.co/120x120/4a90a4/FFFFFF?text=Member+2" class="rounded-circle mb-3 team-img" alt="Team Member 2">
                    <h5 class="card-title">Shivam Das</h5>
                    <p class="text-muted">Roll No: 2548032</p>
                    <p class="card-text"><strong>Contribution:</strong> Frontend Development (HTML, CSS, Bootstrap), UI/UX Design, JavaScript.</p>
                </div>
            </div>
        </div>

        <!-- Team Member 3 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-center team-card h-100">
                <div class="card-body">
                    <img src="https://placehold.co/120x120/4a90a4/FFFFFF?text=Member+3" class="rounded-circle mb-3 team-img" alt="Team Member 3">
                    <h5 class="card-title">Dipika Yadav</h5>
                    <p class="text-muted">Roll No: 2548005</p>
                     <p class="card-text"><strong>Contribution:</strong> System Analysis, Testing, Documentation, and Presentation.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Technologies Used -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="bi bi-code-slash me-2"></i>Technologies Used</h4>
        </div>
        <div class="card-body text-center">
            <span class="badge bg-primary fs-6 m-1 p-2">PHP</span>
            <span class="badge bg-danger fs-6 m-1 p-2">CodeIgniter 4</span>
            <span class="badge bg-info fs-6 m-1 p-2">MySQL</span>
            <span class="badge bg-success fs-6 m-1 p-2">JavaScript</span>
            <span class="badge bg-primary fs-6 m-1 p-2">Bootstrap 5</span>
            <span class="badge bg-warning fs-6 m-1 p-2">HTML5</span>
            <span class="badge bg-secondary fs-6 m-1 p-2">CSS3</span>
        </div>
    </div>
    
    <!-- Acknowledgments -->
    <div class="card shadow-sm">
        <div class="card-header">
             <h4 class="mb-0"><i class="bi bi-award-fill me-2"></i>Acknowledgments</h4>
        </div>
        <div class="card-body">
            <p>We would like to express our sincere gratitude to our faculty, <strong>Prof. Not For Now</strong>, for the invaluable guidance and support throughout this project. We would also like to thank our university for providing us with the resources and opportunity to work on this project.</p>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
