const filterbtns = document.querySelectorAll(".filterbtn button");
    const filtercards = document.querySelectorAll(".filtercards .card");

    const filter = (e) => {
        document.querySelector(".active").classList.remove("active");
        e.target.classList.add("active");

        filtercards.forEach(card => {
            card.classList.add("hide");

            if (card.dataset.name === e.target.dataset.name || e.target.dataset.name === "all") {
                card.classList.remove("hide");
            }
        });
    };



    filterbtns.forEach(button => button.addEventListener("click", filter));