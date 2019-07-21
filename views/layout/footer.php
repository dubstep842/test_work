</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

<script>
    function show() {
        let show = document.getElementById("show");
        while (show.firstChild) {
            show.removeChild(show.firstChild);
        }

        let textimg = document.getElementById("val").textContent;
        let name = document.getElementById("name").value;
        let email = document.getElementById("email").value;
        let text = document.getElementById("text").value;
        let objimg = "";

        if (typeof img !== "undefined") {
            objimg = "<img src=\"" + img + "\" id=\"imgShow\" class=\" my_img\">";
        } else if ((textimg.includes("http://")) || (textimg.includes("https://"))) {
            objimg = "<img src=\"" + textimg + "\" id=\"imgShow\" class=\" my_img\">";
        }

        let divc = document.createElement('div');
        divc.className = "card";
        divc.innerHTML = "<div class=\"card-body\">" +
            objimg +
            "<h5 class=\"card-title\">" + name + "</h5>" +
            "<h6 class=\"card-subtitle mb-2 text-muted\">" + email + "</h6>" +
            "<p class=\"card-text\">" + text + "</p>" +
            "</div>";

        show.appendChild(divc);
    }

    let img;

    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                img = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
<script>
    $("input[type='file']").change(function () {
        $('#val').text(this.value.replace(/C:\\fakepath\\/i, ''))
    })
</script>
</body>
</html>