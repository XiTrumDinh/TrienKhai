const newsItems = document.querySelectorAll(".news-open");

newsItems.forEach(item => {

    item.addEventListener("click", () => {

        const title = item.getAttribute("data-title");

        const content = item.getAttribute("data-content");

        document.getElementById("modalTitle").innerHTML = title;

        document.getElementById("modalArticleContent").innerHTML = content;

        const modal = new bootstrap.Modal(
            document.getElementById("newsModal")
        );

        modal.show();

    });

});