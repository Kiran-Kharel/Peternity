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
    <link rel="stylesheet" href="Assets/css/petlist.css">



</head>

<body>
    <?php include'navbar.php';?>
    <section class="petlistings container">
        <?php 
    include 'viewpets.php';

    $imgdir = "Assets/uploads/";

?>

        <div class="filterbtn">
            <button class="active" data-name="all">Show all</button>
            <button data-name="dog">Dogs</button>
            <button data-name="cat">Cats</button>
            <button data-name="other">Others</button>
        </div>
        <div class="filtercards mt-5">

            <?php
            
                foreach($outputarray as $x){

                    $id = $x['pet_id'];
                    $petName = $x['pet_name'];
                    $species = strtolower(trim($x['species']));
                    $age = $x['age'];
                    $gender = $x['gender'];
                    $gender = (empty($gender))?'Unknown':$gender;
                    $imgprofile = $x['photo_path'];
                    $imgPath = (!empty($imgprofile) && file_exists($imgdir.$imgprofile))? $imgdir.$imgprofile: $imgdir.'default-pet.jpg';

                    echo '<div class="card" id="'.$id.'" data-name="'.$species.'"><img src="'.$imgPath.'" class="card-img-top" alt="'.$petName.'" onerror="this.src=\''.$imgdir.'default-pet.jpg\'"><div class="card-body"><h5 class="card-title">'.$petName.'</h5><p class="card-text">Species: '.$species.' <br>Age: '.$age.' years <br>Gender: '.$gender.'</p></div></div> ';

                }
            
            ?>
        </div>
        <span id="error" class="text-danger"><?php echo $error; ?></span>

    </section>
    <footer class="text-center py-3 bg-light border-top">
        <small>&copy; 2025 PETERNITY. All rights reserved.</small>
    </footer>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('.filterbtn button');
        const petCards = document.querySelectorAll('.filtercards .card');

        // Initialize filter state
        const initialFilter = new URLSearchParams(window.location.search).get('name') || 'all';

        // Universal filter function
        const applyFilter = (filterValue) => {
            petCards.forEach(card => {
                const shouldShow = filterValue === 'all' ||
                    card.dataset.name === filterValue;
                card.style.display = shouldShow ? 'grid' :
                    'none'; // Match your CSS grid/flex layout
            });
        };

        // Button click handler
        const handleFilterClick = (e) => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            e.target.classList.add('active');
            const filterValue = e.target.dataset.name;
            history.replaceState(null, '', `?name=${filterValue}`);
            applyFilter(filterValue);
        };

        // Initial setup
        filterButtons.forEach(btn => {
            if (btn.dataset.name === initialFilter) {
                btn.classList.add('active');
                applyFilter(initialFilter);
            }
            btn.addEventListener('click', handleFilterClick);
        });

        // Fallback for invalid URL param
        if (!document.querySelector('.filterbtn .active')) {
            document.querySelector('[data-name="all"]').click();
        }

        const cards = document.querySelectorAll('.card');

        cards.forEach(card => {

            card.addEventListener('click', () => {
                const pet = card.getAttribute('id');
                window.location.href = `petdetails.php?id=${pet}`;
            });
        });
    });
    </script>
</body>

</html>