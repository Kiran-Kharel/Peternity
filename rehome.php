<?php include 'addprofile.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peternity</title>
    <link rel="shortcut icon" href="Assets\images\petlogo-fav.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/css/navbar.css">
    <style>
    .rehomesection {
        min-height: 100vh;
        width: 100%;
        padding: 20px;
        margin: 50px auto;
    }

    .heading {
        text-align: center;
        color: #213F12;
    }

    .rehomesection .card {
        width: 80%;
        margin: 50px auto;
    }

    #rehomeForm h4 {
        color: #41613A;
    }

    #rehomeForm hr {
        color: rgba(0, 0, 0, 0);
        border-top: 2px dashed #213F12;
        padding: 10px 0px;
    }
    </style>


</head>

<body>
    <?php include 'navbar.php';?>
    <div class="rehomesection container">
        <div class="heading mb-5 pb-5">
            <h1 class="display-5 text-center fw-bold text-body-emphasis">Rehome Your Pet🐾 </h1>
            <p class="fs-4">Help find a loving new home for your companion</p>
        </div>


        <div class="card shadow-lg">
            <div class="card-header text-center" style="background-color: #DFFBF3;">
                <h3 class="mb-0">Pet Profile</h3>
            </div>

            <div class="card-body p-5">
                <form id="rehomeForm" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                    <section class="mb-5">
                        <h4 class=" mb-4">Pet Details</h4>
                        <div class="row g-4 px-4">
                            <div class="col-md-12">
                                <label class="form-label">Pet Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="petName" required
                                    pattern="[A-Za-z ]{2,30}" title="2-30 alphabetic characters">
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Species <span class="text-danger">*</span></label>
                                <select class="form-select" name="species" required>
                                    <option value="">Select...</option>
                                    <option value="dog">Dog</option>
                                    <option value="cat">Cat</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Age</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" min="0" max="30" name="age" step="0.5">
                                    <span class="input-group-text">years</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Gender</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="gender" id="male" value="Male">
                                    <label class="btn btn-outline-primary" for="male">♂ Male</label>

                                    <input type="radio" class="btn-check" name="gender" id="female" value="Female">
                                    <label class="btn btn-outline-primary" for="female">♀ Female</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Pet Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="petBio" rows="4" maxlength="500" required
                                    placeholder="Describe their personality, habits, favorite activities..."></textarea>
                                <div class="form-text text-end"><span id="charCount1">0</span>/500 characters</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Health Status <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="healthinfo" rows="4" maxlength="500" required
                                    placeholder="Include vaccination status, medical conditions, etc."></textarea>
                                <div class="form-text text-end"><span id="charCount2">0</span>/500 characters</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Pet Photo</label>
                                <input type="file" class="form-control" name="petPhoto" accept="image/*">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Reason for Rehoming <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="reason" required></textarea>
                            </div>
                        </div>



                        <div class="d-grid gap-2 mt-5 d-md-flex justify-content-md-center">
                            <button type="submit" name="submit" class="btn btn-success rounded-pill px-5">
                                Submit Rehoming Profile
                            </button>
                            <a href="rehome.php" type="reset" class="btn btn-secondary rounded-pill px-5">Reset</a>
                        </div>
                </form>
                </section>
            </div>
        </div>
    </div>
    <footer class="text-center py-3 bg-light border-top">
        <small>&copy; 2025 PETERNITY. All rights reserved.</small>
    </footer>
    <script>
    document.querySelector('[name="petBio"]').addEventListener('input', function(e) {
        document.getElementById('charCount1').textContent = e.target.value.length;
    });
    document.querySelector('[name="healthinfo"]').addEventListener('input', function(e) {
        document.getElementById('charCount2').textContent = e.target.value.length;
    });
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
    </script>



</body>

</html>