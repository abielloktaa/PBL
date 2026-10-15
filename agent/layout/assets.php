
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { sans: ['Inter', 'sans-serif'] },
                colors: {
                    primary: '#002B58',
                    secondary: '#3770BF',
                    accent: '#5B758C',
                    support: '#91B5FF',
                    surface: '#F5F5F5',
                    brandOrange: '#FF7A00',
                },
                boxShadow: {
                    'soft': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
                    'pop': '0 10px 25px -3px rgba(0, 43, 88, 0.1), 0 4px 6px -2px rgba(0, 43, 88, 0.05)',
                    'pop-hover': '0 20px 35px -5px rgba(0, 43, 88, 0.15), 0 10px 15px -5px rgba(0, 43, 88, 0.1)',
                }
            }
        }
    }
</script>

<style>
    /* Base */
    body {
        background-color: #F1F5F9; 
        font-family: 'Inter', sans-serif;
        color: #002B58;
    }

    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

 
    
   
    .sidebar-solid {
        background: #FFFFFF;
        border-right: 1px solid #E2E8F0;
    }


    .header-solid {
        background: #FFFFFF;
        border-bottom: 1px solid #E2E8F0;
    }


    .product-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 35px -5px rgba(0, 43, 88, 0.15), 0 10px 15px -5px rgba(0, 43, 88, 0.1);
        border-color: rgba(55, 112, 191, 0.4);
    }

    .category-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .category-card:hover {
        background: #F8FAFC;
        border-color: #3770BF;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -3px rgba(0, 43, 88, 0.1);
    }

  
    .input-clean {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        transition: all 0.2s ease;
    }
    .input-clean:focus {
        border-color: #3770BF;
        box-shadow: 0 0 0 4px rgba(55, 112, 191, 0.15);
        outline: none;
    }

    #cart-toggle:checked ~ #cart-drawer {
        opacity: 1;
        visibility: visible;
    }
    #cart-toggle:checked ~ #cart-drawer #cart-content {
        transform: translateX(0);
    }


    .password-wrapper input[type="checkbox"]:checked ~ input[type="password"] {
        -webkit-text-security: none;
    }
    .password-wrapper input[type="checkbox"]:checked ~ .eye-icon::before {
        content: "\f070"; 
    }

   
    .menu-active {
        background: linear-gradient(135deg, #3770BF 0%, #002B58 100%);
        color: #FFFFFF;
        box-shadow: 0 10px 20px -5px rgba(55, 112, 191, 0.4);
    }
    .menu-active i { color: #FFFFFF; }
    .menu-active:hover { transform: translateY(-2px); }


    .menu-item:hover {
        background: #F1F5F9;
        color: #3770BF;
    }
    
</style>


