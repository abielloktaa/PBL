<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Responsive - Galonku Style</title>
    

    <script src="https://cdn.tailwindcss.com"></script>
    
   
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#002B58',   
                        secondary: '#37708F', 
                        accent: '#5B758C',    
                        support: '#91BEF5',   
                        surface: '#F5F5F5',   
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-surface font-sans antialiased text-primary">


    <nav class="bg-primary shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
    
            <div class="flex justify-between items-center h-20">
                
         
                <div class="flex-shrink-0 flex items-center cursor-pointer">
                    <span class="text-2xl font-bold text-white tracking-tight">
                        Galon<span class="text-support">ku</span>
                    </span>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-200 hover:text-support font-medium transition duration-300">Home</a>
                    <a href="#" class="text-gray-200 hover:text-support font-medium transition duration-300">Services</a>
                    <a href="#" class="text-gray-200 hover:text-support font-medium transition duration-300">About Us</a>
                    <a href="#" class="text-gray-200 hover:text-support font-medium transition duration-300">Contact</a>
                </div>

                <div class="hidden md:flex items-center">
                    <a href="login.php" class="bg-support text-primary px-6 py-2.5 rounded-lg font-bold hover:bg-white transition duration-300 shadow-md hover:shadow-lg">
                        Login
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-white hover:text-support focus:outline-none">
             
                        <svg id="icon-hamburger" class="h-6 w-6 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
            
                        <svg id="icon-close" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>


        <div id="mobile-menu" class="hidden md:hidden bg-secondary border-t border-gray-600">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-primary hover:text-support transition">Home</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-primary hover:text-support transition">Services</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-primary hover:text-support transition">About Us</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-primary hover:text-support transition">Contact</a>
                <a href="#" class="block mt-4 text-center bg-support text-primary px-4 py-3 rounded-lg font-bold hover:bg-white transition">Get Started</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-primary mb-6">
            Lorem ipsum dolor <br> <span class="text-support">Galonku Style</span>
        </h1>
        <p class="text-accent text-lg mb-8 max-w-2xl mx-auto">
            lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.
        </p>
        <button class="bg-primary text-white px-8 py-3 rounded-full font-bold hover:bg-secondary transition shadow-lg">
            VIEW DEMO
        </button>
    </main>


    <script>
     
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const iconHamburger = document.getElementById('icon-hamburger');
        const iconClose = document.getElementById('icon-close');

    
        btn.addEventListener('click', () => {
 
            menu.classList.toggle('hidden');
            
    
            iconHamburger.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });


        const links = menu.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
                iconHamburger.classList.remove('hidden');
                iconClose.classList.add('hidden');
            });
        });
    </script>
</body>
</html>