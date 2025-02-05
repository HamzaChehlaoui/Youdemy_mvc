<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
     <!-- Navigation -->
     <nav class="fixed top-0 w-full bg-black shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold text-white">Youdemy</a>
                    <div class="hidden md:flex space-x-8 ml-10">
                        <a href="indexp.php" class="text-white hover:text-gray-300 px-3 py-2">Accueil</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if(!isset($_SESSION['user_id'])){
                    ?>
                    <a href="login.php"><button class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                        Connexion
                    </button></a>
                    <?php }else{?>
                    
                    <a href="loug_out.php"><button class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                    Déconnexion
                    </button></a>
                    <?php }if(isset($_SESSION['role']) && $_SESSION['role']=='student'){?>
                        <a href="My_Courses_Page_student.php"><button class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                    My courses
                    </button></a>
                    <?php }?>
                </div>
            </div>
        </div>
    </nav>
</body>
</html>