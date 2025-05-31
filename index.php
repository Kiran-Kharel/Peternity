<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peternity</title>
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
    <link rel="stylesheet" href="Assets/css/style.css">
    <link rel="stylesheet" href="Assets/css/navbar.css">
    <link rel="stylesheet" href="Assets/css/herosection.css">
    <link rel="stylesheet" href="Assets/css/categorysection.css">
    <link rel="stylesheet" href="Assets/css/rehomebanner.css">
    <link rel="stylesheet" href="Assets/css/featuresection.css">
    <link rel="stylesheet" href="Assets/css/infosection.css">
    


</head>

<body>
    <?php include'navbar.php';?>
    <?php include'herosection.php';?>
    <?php include'categorysection.php';?>
    <?php include'rehomebanner.php';?>
    <?php include'featuresection.php';?>
    <?php include'infosection.php';?>

    <script>
    const cards = document.querySelectorAll('.card');

    cards.forEach(card => {

        card.addEventListener('click', () => {
            const category = card.getAttribute('data-name');
            window.location.href = `petlist.php?name=${category}`;
        });
    });
    </script>

</body>

</html>