<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

// 1. SERVER-SIDE VALIDATION LOGIC (Refined)
if (isset($_POST['update_profile'])) {
    $full_name = mysqli_real_escape_string($conn, strip_tags(trim($_POST['full_name'])));
    $email     = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone     = mysqli_real_escape_string($conn, trim($_POST['phone']));
    
    // PHP check (Security Layer)
    if (empty($full_name) || strlen($full_name) < 3) {
        $error_msg = "Please enter a valid Name (min 3 characters)!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Please enter a valid Email address!";
    } elseif (!empty($phone) && !preg_match('/^[0-9+]{10,15}$/', $phone)) {
        $error_msg = "Phone number must be 10-15 digits!";
    } else {
        // Email Unique Check
        $check_email = $conn->query("SELECT user_id FROM users WHERE email='$email' AND user_id != '$user_id'");
        if ($check_email->num_rows > 0) {
            $error_msg = "This email is already registered!";
        } else {
            $image_sql = "";
            if (!empty($_FILES['profile_pic']['name'])) {
                $file_ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
                $allowed  = array('jpg', 'jpeg', 'png', 'webp');
                
                if (!in_array($file_ext, $allowed)) {
                    $error_msg = "Only JPG, PNG & WebP images are allowed!";
                } elseif ($_FILES['profile_pic']['size'] > 2000000) { // 2MB
                    $error_msg = "Image size must be under 2MB!";
                } else {
                    $file_name = time() . '_' . $user_id . '.' . $file_ext;
                    $target = "uploads/profiles/" . $file_name;
                    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
                        $image_sql = ", profile_pic='$file_name'";
                    }
                }
            }

            if (empty($error_msg)) {
                $sql = "UPDATE users SET full_name='$full_name', email='$email', phone='$phone' $image_sql WHERE user_id='$user_id'";
                if ($conn->query($sql)) {
                    $success_msg = "Profile updated successfully!";
                    // if a new picture was uploaded, sync it to the session
                    if (!empty($file_name)) {
                        $_SESSION['profile_pic'] = $file_name;
                    }
                } else {
                    $error_msg = "Database update failed!";
                }
            }
        }
    }
}

// Fetch Current Data
$user = $conn->query("SELECT * FROM users WHERE user_id = '$user_id'")->fetch_assoc();
$booking_count = $conn->query("SELECT COUNT(*) as total FROM payments WHERE user_name = '".mysqli_real_escape_string($conn, $user['full_name'])."'")->fetch_assoc()['total'];

include('header.php');
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = { theme: { extend: { colors: { movixo: '#FF6B00' }, fontFamily: { poppins: ['Poppins', 'sans-serif'] } } } }
</script>

<div class="container mx-auto px-4 py-16 min-h-screen bg-black text-white font-poppins">
    
    <div class="max-w-4xl mx-auto mb-8">
        <?php if($success_msg): ?>
            <div class="bg-green-500/20 border border-green-500 text-green-500 p-5 rounded-2xl font-bold flex items-center gap-3">
                <i class="fas fa-check-circle"></i> <?= $success_msg ?>
            </div>
        <?php endif; ?>
        <?php if($error_msg): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-500 p-5 rounded-2xl font-bold flex items-center gap-3">
                <i class="fas fa-exclamation-triangle"></i> <?= $error_msg ?>
            </div>
        <?php endif; ?>
    </div>

    <form action="" method="POST" enctype="multipart/form-data" id="profileForm" class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <div class="lg:col-span-4">
                <div class="bg-[#0D0D0D] border border-gray-900 rounded-[3rem] p-10 text-center">
                    <div class="relative inline-block mb-6">
                        <div id="dp-box" class="w-44 h-44 rounded-[2.5rem] border-4 border-gray-900 overflow-hidden bg-black flex items-center justify-center">
                            <?php if(!empty($user['profile_pic'])): ?>
                                <img src="uploads/profiles/<?= $user['profile_pic'] ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-7xl font-black text-movixo"><?= strtoupper(substr($user['full_name'] ?? 'U', 0, 1)) ?></span>
                            <?php endif; ?>
                        </div>
                        <label class="absolute bottom-2 right-2 w-12 h-12 bg-movixo rounded-2xl flex items-center justify-center text-black cursor-pointer hover:scale-110 transition-all border-4 border-black">
                            <i class="fas fa-camera"></i>
                            <input type="file" name="profile_pic" id="picInput" class="hidden" accept=".jpg,.jpeg,.png,.webp">
                        </label>
                    </div>
                    <h3 class="text-2xl font-extrabold uppercase"><?= htmlspecialchars($user['full_name']) ?></h3>
                </div>
            </div>

            <div class="lg:col-span-8 bg-[#0D0D0D] border border-gray-900 rounded-[3rem] p-10 md:p-14">
                <h4 class="text-3xl font-black uppercase mb-12 flex items-center gap-4">
                    <span class="w-2 h-10 bg-movixo rounded-full"></span> Edit Profile
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Full Name</label>
                        <input type="text" name="full_name" required minlength="3" value="<?= htmlspecialchars($user['full_name']) ?>" 
                               class="w-full bg-black border border-gray-800 p-5 rounded-2xl focus:border-movixo outline-none transition-all">
                    </div>

                    <div class="space-y-3">
                        <label class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Email Address</label>
                        <input type="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>" 
                               class="w-full bg-black border border-gray-800 p-5 rounded-2xl focus:border-movixo outline-none transition-all">
                    </div>

                    <div class="space-y-3">
                        <label class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Contact Number</label>
                        <input type="tel" name="phone" pattern="[0-9+]{10,15}" title="Please enter 10 to 15 digits" 
                               value="<?= htmlspecialchars($user['phone'] ?? '') ?>" 
                               class="w-full bg-black border border-gray-800 p-5 rounded-2xl focus:border-movixo outline-none transition-all">
                    </div>

                    <div class="space-y-3">
                        <label class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Bookings Count</label>
                        <div class="w-full bg-black/40 border border-gray-900 p-5 rounded-2xl text-movixo font-black text-xl">
                            <?= $booking_count ?>
                        </div>
                    </div>
                </div>

                <div class="mt-16 flex items-center gap-6">
                    <button type="submit" name="update_profile" class="bg-movixo hover:bg-white text-black font-black px-12 py-5 rounded-2xl text-xs uppercase transition-all shadow-xl shadow-movixo/30">
                        Save Changes
                    </button>
                    <a href="index.php" class="text-gray-400 hover:text-white uppercase font-bold text-xs">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // JS Validation for Profile Picture Size & Preview
    document.getElementById('picInput').onchange = function() {
        if(this.files[0].size > 2000000) {
            alert("Bhai, image 2MB se kam honi chahiye!");
            this.value = "";
        } else {
            let reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById('dp-box').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(this.files[0]);
        }
    };

    // Client-side confirmation (Optional)
    document.getElementById('profileForm').onsubmit = function() {
        return confirm("Are you sure you want to update your profile?");
    };
</script>

<?php include('footer.php'); ?>