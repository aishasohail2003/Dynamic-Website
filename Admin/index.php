<?php

session_start();

include_once __DIR__ . '../../connection/config.php';



// --- FINAL SECURITY LOGIC ---

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {

    header("Location: ../User/login.php");

    exit();

}



include_once __DIR__ . '../../inc/header.php';

?>



<!-- user name display removed; only sidebar logout remains -->
<div class="mb-8 flex justify-between items-center">
    <?php if (isset($_SESSION['full_name'])): ?>
        <div>
            <p class="text-gray-500 text-[10px] font-black uppercase tracking-[0.3em]">Logged in as</p>
            <h1 class="text-white text-2xl font-black italic uppercase tracking-tighter">
                <i class="fas fa-user-shield text-red-600 mr-2"></i>
                <?php echo htmlspecialchars($_SESSION['full_name']); ?>
            </h1>
        </div>
    <?php endif; ?>
</div>



<div class="mb-10">

    <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">

        ADMIN <span class="text-red-600">DASHBOARD</span>

    </h2>

    <p class="text-gray-500 text-sm font-medium mt-1">

        Overview of your cinema's performance and quick management.

    </p>

</div>



<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

    <?php

    $m_count = $conn->query("SELECT count(*) as total FROM movies")->fetch_assoc()['total'];

    $b_count = $conn->query("SELECT count(*) as total FROM bookings")->fetch_assoc()['total'];

    $u_count = $conn->query("SELECT count(*) as total FROM users WHERE role='user'")->fetch_assoc()['total'];

   

    $rev_res = $conn->query("SELECT sum(total_amount) as total FROM bookings")->fetch_assoc()['total'];

    $revenue = $rev_res ? $rev_res : 0;

    ?>



    <div class="bg-[#161616] border border-gray-800 p-6 rounded-2xl shadow-xl">

        <div class="flex justify-between items-start">

            <div>

                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Total Movies</p>

                <h2 class="text-3xl font-black mt-2 text-white"><?= $m_count ?></h2>

            </div>

            <div class="p-3 bg-red-600/10 rounded-xl text-red-600">

                <i class="fas fa-film"></i>

            </div>

        </div>

    </div>



    <div class="bg-[#161616] border border-gray-800 p-6 rounded-2xl shadow-xl">

        <div class="flex justify-between items-start">

            <div>

                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Total Bookings</p>

                <h2 class="text-3xl font-black mt-2 text-white"><?= $b_count ?></h2>

            </div>

            <div class="p-3 bg-blue-600/10 rounded-xl text-blue-600">

                <i class="fas fa-ticket-alt"></i>

            </div>

        </div>

    </div>



    <div class="bg-[#161616] border border-gray-800 p-6 rounded-2xl shadow-xl">

        <div class="flex justify-between items-start">

            <div>

                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Active Users</p>

                <h2 class="text-3xl font-black mt-2 text-white"><?= $u_count ?></h2>

            </div>

            <div class="p-3 bg-purple-600/10 rounded-xl text-purple-600">

                <i class="fas fa-users"></i>

            </div>

        </div>

    </div>



    <div class="bg-[#161616] border border-gray-800 p-6 rounded-2xl shadow-xl border-l-4 border-l-green-600">

        <div class="flex justify-between items-start">

            <div>

                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Revenue</p>

                <h2 class="text-3xl font-black mt-2 text-green-500">Rs. <?= number_format($revenue) ?></h2>

            </div>

            <div class="p-3 bg-green-600/10 rounded-xl text-green-600">

                <i class="fas fa-wallet"></i>

            </div>

        </div>

    </div>

</div>



<section class="bg-[#161616] border border-gray-800 rounded-3xl p-8 shadow-2xl">

    <div class="flex justify-between items-center mb-8">

        <h3 class="text-xl font-black text-white uppercase italic tracking-tighter">

            Recent <span class="text-red-600">Movies</span>

        </h3>

        <button onclick="location.href='movies/add_movie.php'" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">

            Add New Movie

        </button>

    </div>



    <div class="overflow-x-auto">

        <table class="w-full text-left">

            <thead>

                <tr class="text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-gray-800">

                    <th class="pb-4">Title</th>

                    <th class="pb-4">Genre</th>

                    <th class="pb-4">Duration</th>

                    <th class="pb-4">Status</th>

                    <th class="pb-4 text-right">Actions</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-800/50">

                <?php

                $movies = $conn->query("SELECT * FROM movies ORDER BY movie_id DESC LIMIT 5");

                while($row = $movies->fetch_assoc()):

                    // SIRF STATUS LOGIC: Active check and Color set

                    $status = $row['status'];

                    $statusClass = (strtolower($status) == 'active') ? 'bg-green-500/10 text-green-500 border-green-500/20' : 'bg-red-500/10 text-red-500 border-red-500/20';

                ?>

                <tr class="hover:bg-white/[0.02] transition">

                    <td class="py-5 font-bold text-white"><?= $row['title'] ?></td>

                    <td class="py-5 text-gray-400 text-sm"><?= $row['genre'] ?></td>

                    <td class="py-5 text-gray-400 text-sm font-mono"><?= $row['duration'] ?> min</td>

                    <td class="py-5">

                        <span class="px-3 py-1 border rounded-full text-[10px] font-black uppercase tracking-tighter <?= $statusClass ?>">

                            <?= $status ?>

                        </span>

                    </td>

                    <td class="py-5 text-right">

                        <div class="flex justify-end items-center gap-3">

                            <a href="movies/edit_movie.php?id=<?= $row['movie_id'] ?>" class="w-9 h-9 rounded-xl bg-blue-500/5 text-blue-400 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all border border-blue-500/10">

                                <i class="fas fa-edit text-xs"></i>

                            </a>

                            <a href="movies/process_movie.php?delete_id=<?= $row['movie_id'] ?>" onclick="return confirm('Delete?')" class="w-9 h-9 rounded-xl bg-red-500/5 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all border border-red-500/10">

                                <i class="fas fa-trash-alt text-xs"></i>

                            </a>

                        </div>

                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</section>



<?php include_once __DIR__ . '../../inc/footer.php'; ?>