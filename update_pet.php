<?php
include 'check_user.php';
include 'connect.php';
$imgdir = 'Assets/uploads/';
$pet_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

    $check_query = "SELECT * FROM pet_details WHERE pet_id = $pet_id AND user_id = $user_id";
    $check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) === 1) {
    $pet = mysqli_fetch_assoc($check_result);
} else {
    die("Pet not found or access denied.");
}

if (isset($_POST['update'])) {

        $pet_name = mysqli_real_escape_string($conn, $_POST['petName']);
        $species = mysqli_real_escape_string($conn, $_POST['species']);
        $age = $_POST['age'];
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $bio = mysqli_real_escape_string($conn, $_POST['petBio']);
        $health_info = mysqli_real_escape_string($conn, $_POST['healthinfo']);
        $rehoming_reason = mysqli_real_escape_string($conn, $_POST['reason']);

        if (isset($_FILES['petPhoto']) && $_FILES['petPhoto']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['petPhoto']['name'], PATHINFO_EXTENSION);
            $photo_path = 'pet_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['petPhoto']['tmp_name'], $imgdir . $photo_path);

            $update_query = "
                UPDATE pet_details SET
                    pet_name = '$pet_name',
                    species = '$species',
                    age = $age,
                    gender = '$gender',
                    bio = '$bio',
                    health_info = '$health_info',
                    rehoming_reason = '$rehoming_reason',
                    photo_path = '$photo_path'
                WHERE pet_id = $pet_id";
        } else {
            $update_query = "
                UPDATE pet_details SET
                    pet_name = '$pet_name',
                    species = '$species',
                    age = $age,
                    gender = '$gender',
                    bio = '$bio',
                    health_info = '$health_info',
                    rehoming_reason = '$rehoming_reason'
                WHERE pet_id = $pet_id";
        }

        if (mysqli_query($conn, $update_query)) {
            header("Location: userprofile.php");
            exit();
        } else {
            die("Update failed: " . mysqli_error($conn));
        }
    
} 
?>
<!DOCTYPE html>
<html>

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

    .petimage {
        width: 200px;
        height: 200px;
        display: flex;
        overflow: hidden;
        border: 2px solid #666;
        border-radius: 50%;
    }

    .petimage img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    </style>


</head>

<body>
    <?php include 'navbar.php';?>
    <div class="rehomesection container">
        <div class="heading mb-5 pb-5">
            <h1 class="display-5 text-center fw-bold text-body-emphasis">Update Pet Profile🐾 </h1>
        </div>


        <div class="card shadow-lg">
            <div class="card-header text-center" style="background-color: #DFFBF3;">
                <h3 class="mb-0">Pet Details</h3>
            </div>

            <div class="card-body p-5">
                <form id="rehomeForm" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                    <section class="mb-5">
                        <div class="row g-4 px-4">
                            <div class="col-4">
                                <label class="form-label">Pet Photo</label>
                                <div class="petimage">
                                    <img src="Assets/uploads/<?= $pet['photo_path'] ?>" alt="<?= $pet['pet_name'] ?>"
                                        class="img-fluid" onerror="this.src='Assets/images/default-pet.jpg'">
                                </div>

                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Pet Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="petName" value="<?= $pet['pet_name'] ?>"
                                    required pattern="[A-Za-z ]{2,30}" title="2-30 alphabetic characters">
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Species <span class="text-danger">*</span></label>
                                <select class="form-select" name="species" value="<?= $pet['species'] ?>" required>
                                    <!-- <option value="">Select...</option>
                                    <?php if($pet['species'] == 'dog'): ?>
                                    <option value="dog" selected>Dog</option>
                                    <?php elseif($pet['species'] == 'cat'): ?>
                                    <option value="cat" selected>Cat</option>
                                    <?php elseif($pet['species'] == 'other'): ?>
                                    <option value="other" selected>Other</option>
                                    <?php endif; ?> -->
                                    <option value="">Select...</option>
                                    <option value="dog">Dog</option>
                                    <option value="cat">Cat</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Age</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" min="0" max="30" name="age" step="0.5"
                                        value="<?= $pet['age'] ?>">
                                    <span class="input-group-text">years</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Gender</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="gender" id="male" value="Male"
                                        <?= $pet['gender'] == 'Male' ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-primary" for="male">♂ Male</label>

                                    <input type="radio" class="btn-check" name="gender" id="female" value="Female"
                                        <?= $pet['gender'] == 'Female' ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-primary" for="female">♀ Female</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Pet Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="petBio" rows="4" maxlength="500" required
                                    placeholder="Describe their personality, habits, favorite activities..."><?= $pet['bio'] ?></textarea>
                                <div class="form-text text-end"><span id="charCount1">0</span>/500 characters</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Health Status <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="healthinfo" rows="4" maxlength="500" required
                                    placeholder="Include vaccination status, medical conditions, etc."><?= $pet['health_info'] ?></textarea>
                                <div class="form-text text-end"><span id="charCount2">0</span>/500 characters</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Pet Photo</label>
                                <input type="file" class="form-control" name="petPhoto" accept="image/*"
                                    value="<?= $pet['photo_path'] ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Reason for Rehoming <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="reason"
                                    required><?= $pet['rehoming_reason'] ?></textarea>
                            </div>

                        </div>
                    </section>
                    <!-- <section class="mb-5">
                        <h4 class=" mb-4">Contact Information</h4>
                        <div class="row g-4 px-4">
                            <!-- <div class="col-md-10">
                                <label class="form-label">Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="ownerName" pattern="[A-Za-z ]{5,50}" value="<?= $pet['owner_name'] ?>"
                                    required>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email"
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?= $pet['email'] ?>" required>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone" pattern="[0-9]{10}" value="<?= $pet['phone'] ?>">
                            </div>
                            <div class="col-md-10">
                                <label class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="location" placeholder="City, State"
                                    value="<?= $pet['location'] ?>" required>
                            </div>
                        </div>
                    </section> -->

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="submit" name="update" class="btn btn-success rounded-pill px-5">
                            Update Pet Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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