<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Kampus Peduli UPNVJ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&amp;display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet" />
    <style>
        * {
            font-family: "Josefin Sans", sans-serif;
        }
    </style>
</head>

<body class="bg-teal-900 text-white">
    <div id="addProjectPopup"
        class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full text-center z-50">
            <h1 class="text-black">Tambahkan Project</h1>
            <button id="closeAddProjectPopup" class="bg-[#EC5A49] px-4 py-2 rounded-lg">
                Tutup
            </button>
        </div>
    </div>
    <script>
        window.user = {}
    </script>
    <header class="flex justify-between items-center p-6 z-50">
        <div class="text-lg font-bold -ml-4 lg:ml-16">
            <img src="../../logo.svg" />
        </div>
        <nav class="space-x-2 lg:space-x-6 ml-4 flex flex-row ml-auto mr-auto">
            <a class="text-white hover:text-red-500 text-md lg:text-lg duration-300" href="../../">
                Home
            </a>
            <a class="text-white hover:text-red-500 text-md lg:text-lg duration-300" href="../../contact/">
                Contact
            </a>
            <a class="text-white hover:text-red-500 text-md lg:text-lg text-nowrap duration-300" href="../../about_us/">
                About Us
            </a>
            <a class="text-white hover:text-red-500 text-md lg:text-lg text-nowrap" href="../../donation/list/">
                List Donasi
            </a>
            <a class="text-white hover:text-red-500 text-md lg:text-lg text-nowrap" href="../../login/" id="login-btn">
                Masuk / Daftar
            </a>
            <script>
                fetch("../../api/my_user/", {
                    credentials: "include"
                })
                    .then(x => x.json())
                    .then(res => {
                        if (res.id) {
                            window.user = res
                            const loginBtn = document.getElementById("login-btn")
                            loginBtn.innerText = "Dashboard"
                            loginBtn.href = "/dashboard"
                        }
                    })
            </script>
        </nav>
    </header>
    <div
        class="bg-[url('../../donation.webp')] bg-cover h-screen w-screen max-w-screen brightness-[70%] fixed top-0 -z-10">
    </div>
    <div>
        <h1 class="text-2xl lg:text-4xl text-center mt-36 lg:mt-72 mb-16">
            Bosan scrolling timeline? Yuk, ganti jadi scrolling kebaikan<br />
            Donasi sekarang dan rasakan sensasi jadi orang baik!
        </h1>
        <div class="w-[90vw] lg:w-[90vw] bg-[#F8F4E8] mx-auto rounded-t-[35px] px-4 lg:px-16 py-10 text-black">
            <h1 class="font-bold text-center text-xl lg:text-2xl">Carilah donasi sebanyak mungkin</h1>
            <div class="flex justify-center gap-x-8 mt-8">
                <input id="search" type="text" class="py-3 px-6 text-lg w-full max-w-[500px] rounded-full" onchange=""
                    placeholder="Tuliskan judul donasi yang ingin dicari...">
                <div class="bg-white px-6 rounded-full flex justify-center items-center">
                    <select id="category" name="category" id="category"
                        class="py-3 text-lg w-full max-w-[300px] rounded-full focus:outline-none">
                        <option value="Semua">Semua</option>
                        <option value="Pendidikan">Dana Pendidikan</option>
                        <option value="Bencana Alam">Dana Bencana Alam</option>
                        <option value="Sosial">Dana sosial</option>
                    </select>
                </div>
                <div id="add-project" class="">
                    <button class="bg-[#EC5A49] text-white px-4 py-4 rounded-lg">Tambahkan Project </button>
                </div>
            </div>
            <div class="mt-8">
                <div id="project-container"
                    class="flex flex-row flex-wrap justify-center gap-5 cursor-grab active:cursor-grabbing transition-transform duration-300 ease-linear">
                </div>
            </div>
        </div>
    </div>
    <script>
        const addProjectPopup = document.getElementById('addProjectPopup');
        const showPopupButton = document.getElementById('add-project');
        const closeAddProjectPopup = document.getElementById('closeAddProjectPopup');
        showPopupButton.addEventListener("click", (e) => {
            addProjectPopup.classList.remove("hidden")
        })
        closeAddProjectPopup.addEventListener('click', function () {
            addProjectPopup.classList.add('hidden');
        });

        window.addEventListener('click', function (e) {
            if (e.target === addProjectPopup) {
                addProjectPopup.classList.add('hidden');
            }
        });
    </script>
</body>
<script>
    let projectData;

    const search = document.getElementById("search")
    const category = document.getElementById("category")

    search.addEventListener("input", (e) => {
        const searchTerm = e.target.value
        let result = []
        projectData.forEach(d => {
            if (d.category === category.value || category.value === "Semua") {
                if (d.title.toLowerCase().includes(searchTerm.toLowerCase())) {
                    result.push(d)
                } else if (d.description.toLowerCase().includes(searchTerm.toLowerCase())) {
                    result.push(d)
                }
            }
        })
        render(result)
    })
    category.addEventListener("change", (e) => {
        const searchTerm = search.value
        let result = []
        projectData.forEach(d => {
            if (d.category === e.target.value || category.value === "Semua") {

                if (d.title.toLowerCase().includes(searchTerm.toLowerCase())) {
                    result.push(d)
                } else if (d.description.toLowerCase().includes(searchTerm.toLowerCase())) {
                    result.push(d)
                }
            }
        })
        render(result)
    })
    function render(data) {
        const container = document.getElementById('project-container');
        container.innerHTML = '';
        if (data.length == 0) {
            container.innerHTML = `
            <h1 class="text-xl my-8">Project tidak ditemukan</h1>
            `;
            return
        }
        let html = ``
        data.forEach(project => {
            const progress = (project.donation / project.donation_target) * 100;
            const projectHTML = `
                    <div class="bg-teal-900 text-white rounded-lg h-[540px] max-w-[450px]">
                        <img alt="${project.title}" class="mb-4 rounded-lg w-full h-48 object-cover"
                            src="../../project${project.id}.webp" />
                        <div class="py-6 px-9 flex flex-col h-[320px]">
                            <span class="bg-[#EC5A49] px-4 rounded-full mr-auto">Bantuan ${project.category}</span>
                            <h3 class="text-xl font-bold my-2 text-left">
                                ${project.title}
                            </h3>
                            <p class="text-lg mb-4 text-left font-light text-ellipsis line-clamp-3">
                                ${project.description}
                            </p>
                            <div class="flex flex-row mt-auto">
                                <div class="flex flex-col">
                                    <div class="bg-[#F8F4E8] h-3 w-full rounded-full mb-4">
                                        <div class="bg-[#EC5A49] h-3 rounded-full" style="width: ${progress}%;"></div>
                                    </div>
                                    <p class="text-sm mr-auto">
                                        Terkumpul Rp. ${parseInt(project.donation).toLocaleString('id-ID')} / Rp. ${parseInt(project.donation_target).toLocaleString('id-ID')}
                                    </p>
                                </div>
                                <div class="flex justify-center items-center ml-auto">
                                    <a class="bg-[#EC5A49] text-white px-5 py-3 rounded-lg mb-4 inline-flex items-center font-bold hover:opacity-50 active:scale-97 duration-300 lg:mr-auto mx-auto lg:ml-0" 
                                    href="../../donation"> Donasi</a>
                                </div>
                            </div>
                        </div>
                    </div>`
                ;
            html = html + projectHTML
        });
        container.innerHTML = html;
    }
    fetch('../../api/projects/')
        .then(response => response.json())
        .then(res => {
            const data = res.data
            projectData = data
            activeProjects = data
            render(data)
        })
        .catch(error => {
            console.error('Error fetching project data:', error);
        });
</script>

</html>