<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

function render_text($text) {
    if ($text === null || $text === '') return '';
    
    $placeholders = [];
    $p_idx = 0;

    $text = preg_replace_callback('/```([a-zA-Z\+]*)\n([\s\S]*?)```/i', function($m) use (&$placeholders, &$p_idx) {
        $lang = strtolower($m[1] ?: 'text');
        $code = $m[2];
        
        $label = "";
        if($lang === 'python' || $lang === 'py') $label = '<span class="text-[10px] font-bold text-indigo-400 border border-indigo-500/30 px-2 py-0.5 rounded uppercase mb-2 inline-block"><i class="fa-brands fa-python"></i> Python</span><br>';
        else if($lang === 'cpp' || $lang === 'c++' || $lang === 'c') $label = '<span class="text-[10px] font-bold text-amber-400 border border-amber-500/30 px-2 py-0.5 rounded uppercase mb-2 inline-block"><i class="fa-solid fa-code"></i> C++</span><br>';
        else if($lang === 'html') $label = '<span class="text-[10px] font-bold text-rose-400 border border-rose-500/30 px-2 py-0.5 rounded uppercase mb-2 inline-block"><i class="fa-brands fa-html5"></i> HTML</span><br>';
        else if($lang === 'pascal') $label = '<span class="text-[10px] font-bold text-blue-400 border border-blue-500/30 px-2 py-0.5 rounded uppercase mb-2 inline-block">Pascal</span><br>';
        else if($lang && $lang !== 'text') $label = '<span class="text-[10px] font-bold text-slate-400 border border-slate-500/30 px-2 py-0.5 rounded uppercase mb-2 inline-block">' . htmlspecialchars($lang, ENT_QUOTES) . '</span><br>';
        
        $escapedCode = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');
        $html = '<div class="bg-slate-800 text-emerald-400 p-4 rounded-lg mt-2 mb-2 font-mono text-sm overflow-x-auto whitespace-pre-wrap leading-relaxed">' . $label . '<code>' . $escapedCode . '</code></div>';
        
        $key = "%%%CODE_{$p_idx}%%%";
        $placeholders[$key] = $html;
        $p_idx++;
        return $key;
    }, $text);

    $text = preg_replace_callback('/(?:<|&lt;)code(?:>|&gt;)(.*?)(?:<|&lt;)\/code(?:>|&gt;)/is', function($m) use (&$placeholders, &$p_idx) {
        $inner = htmlspecialchars_decode($m[1], ENT_QUOTES);
        $escapedCode = htmlspecialchars($inner, ENT_QUOTES, 'UTF-8');
        $html = '<code>' . $escapedCode . '</code>';
        $key = "%%%CODE_{$p_idx}%%%";
        $placeholders[$key] = $html;
        $p_idx++;
        return $key;
    }, $text);

    $sys_regexes = [
        '/<table class="w-full border-collapse border border-slate-300 mt-2 mb-2">[\s\S]*?<\/table>/is',
        '/<img src="[^"]+" style="max-height:150px; border-radius:5px; margin-top:5px; border: 1px solid #e2e8f0;" \/>/is'
    ];
    foreach ($sys_regexes as $regex) {
        $text = preg_replace_callback($regex, function($m) use (&$placeholders, &$p_idx) {
            $key = "%%%SYSHTML_{$p_idx}%%%";
            $placeholders[$key] = $m[0];
            $p_idx++;
            return $key;
        }, $text);
    }

    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false);
    
    $tags = 'br|b|strong|i|em|u';
    $text = preg_replace_callback('/&lt;(\/?(?:' . $tags . ')\b.*?)&gt;/is', function($m) {
        return '<' . htmlspecialchars_decode($m[1], ENT_QUOTES) . '>';
    }, $text);
    
    foreach($placeholders as $key => $html) {
        $text = str_replace($key, $html, $text);
    }
    
    return $text;
}

$db_host = 'localhost';
$db_name = 'ywvpewmp_tinhoc';
$db_user = 'ywvpewmp_tinhoc';
$db_pass = 'ywvpewmp_tinhoc';

try {
   $pdo_setup = new PDO("mysql:host=$db_host", $db_user, $db_pass);
   $pdo_setup->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $pdo_setup->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
   
   $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
       PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
   ]);

   $tables = [
       "CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50) UNIQUE NOT NULL, password VARCHAR(255) NOT NULL, fullname VARCHAR(100) NOT NULL, role ENUM('admin', 'user') DEFAULT 'user', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)",
       "CREATE TABLE IF NOT EXISTS exams (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255) NOT NULL, code VARCHAR(50) NOT NULL, duration INT NOT NULL, description TEXT, status ENUM('active', 'inactive') DEFAULT 'active', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)",
       "CREATE TABLE IF NOT EXISTS questions (id INT AUTO_INCREMENT PRIMARY KEY, exam_id INT, q_type ENUM('mcq', 'tf') NOT NULL, q_index INT, content TEXT, layout VARCHAR(50) DEFAULT 'normal', left_content TEXT, right_content TEXT, FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE)",
       "CREATE TABLE IF NOT EXISTS answers_mcq (question_id INT PRIMARY KEY, opt_a TEXT, opt_b TEXT, opt_c TEXT, opt_d TEXT, correct_opt CHAR(1), FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE)",
       "CREATE TABLE IF NOT EXISTS answers_tf (question_id INT PRIMARY KEY, part_a TEXT, is_a_true TINYINT(1), part_b TEXT, is_b_true TINYINT(1), part_c TEXT, is_c_true TINYINT(1), part_d TEXT, is_d_true TINYINT(1), FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE)",
       "CREATE TABLE IF NOT EXISTS results (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT, exam_id INT, score DECIMAL(4,2), mcq_score DECIMAL(4,2), tf_score DECIMAL(4,2), time_taken INT, ip VARCHAR(45), device TEXT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE)",
       "CREATE TABLE IF NOT EXISTS result_details (id INT AUTO_INCREMENT PRIMARY KEY, result_id INT, question_id INT, user_answer TEXT, is_correct TINYINT(1), points DECIMAL(4,2), FOREIGN KEY (result_id) REFERENCES results(id) ON DELETE CASCADE, FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE)",
       "CREATE TABLE IF NOT EXISTS settings (setting_key VARCHAR(50) PRIMARY KEY, setting_value TEXT)"
   ];
   foreach ($tables as $sql) { $pdo->exec($sql); }

   $patches = [
       "ALTER TABLE answers_mcq CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
       "ALTER TABLE answers_tf CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
       "ALTER TABLE questions CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
       "ALTER TABLE result_details CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
       "ALTER TABLE exams CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
       "ALTER TABLE users CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
       "ALTER TABLE users ADD COLUMN IF NOT EXISTS fullname VARCHAR(100) NOT NULL AFTER password",
       "ALTER TABLE exams ADD COLUMN IF NOT EXISTS code VARCHAR(50) NOT NULL AFTER title",
       "ALTER TABLE exams ADD COLUMN IF NOT EXISTS duration INT NOT NULL DEFAULT 45",
       "ALTER TABLE exams ADD COLUMN IF NOT EXISTS description TEXT",
       "ALTER TABLE exams ADD COLUMN IF NOT EXISTS status ENUM('active', 'inactive') DEFAULT 'active'",
       "ALTER TABLE questions ADD COLUMN IF NOT EXISTS q_type ENUM('mcq', 'tf') NOT NULL DEFAULT 'mcq' AFTER exam_id",
       "ALTER TABLE questions ADD COLUMN IF NOT EXISTS q_index INT NOT NULL DEFAULT 0 AFTER q_type",
       "ALTER TABLE questions ADD COLUMN IF NOT EXISTS content TEXT",
       "ALTER TABLE questions MODIFY COLUMN layout VARCHAR(50) DEFAULT 'normal'",
       "ALTER TABLE questions ADD COLUMN IF NOT EXISTS left_content TEXT",
       "ALTER TABLE questions ADD COLUMN IF NOT EXISTS right_content TEXT",
       "ALTER TABLE results ADD COLUMN IF NOT EXISTS score DECIMAL(4,2)",
       "ALTER TABLE results ADD COLUMN IF NOT EXISTS mcq_score DECIMAL(4,2)",
       "ALTER TABLE results ADD COLUMN IF NOT EXISTS tf_score DECIMAL(4,2)",
       "ALTER TABLE results ADD COLUMN IF NOT EXISTS time_taken INT",
       "ALTER TABLE results ADD COLUMN IF NOT EXISTS ip VARCHAR(45)",
       "ALTER TABLE results ADD COLUMN IF NOT EXISTS device TEXT",
       "ALTER TABLE result_details ADD COLUMN IF NOT EXISTS user_answer TEXT",
       "DELETE FROM questions WHERE id NOT IN (SELECT question_id FROM answers_mcq) AND id NOT IN (SELECT question_id FROM answers_tf)",
       "UPDATE questions SET layout = 'python,cpp' WHERE layout = 'dual'"
   ];
   foreach ($patches as $patch) { try { $pdo->exec($patch); } catch (Exception $e) {} }

   $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'");
   if ($stmt->fetchColumn() == 0) {
       $default_pw = password_hash('admin123', PASSWORD_BCRYPT);
       $pdo->exec("INSERT INTO users (username, password, fullname, role) VALUES ('admin', '$default_pw', 'Quản Trị Viên', 'admin')");
   }

   $stmt = $pdo->query("SELECT COUNT(*) FROM settings");
   if ($stmt->fetchColumn() == 0) {
       $pdo->exec("INSERT INTO settings (setting_key, setting_value) VALUES 
           ('logo_type', 'icon'), 
           ('logo_icon', 'fa-solid fa-laptop-code'), 
           ('logo_image', ''), 
           ('favicon', '')");
   }

} catch (PDOException $e) { die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage()); }

if (empty($_SESSION['csrf_token'])) { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); }
function verify_csrf() { if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) { die("Lỗi CSRF Token!"); } }
function is_logged_in() { return isset($_SESSION['user_id']); }
function is_admin() { return isset($_SESSION['role']) && $_SESSION['role'] === 'admin'; }

$site_settings = [];
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    while ($row = $stmt->fetch()) {
        $site_settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (Exception $e) {}

$action = isset($_GET['action']) ? $_GET['action'] : 'home';
if ($action == 'home' && is_admin()) { $action = 'admin'; }
$msg = ''; $msg_type = 'success';

if ($action == 'ajax_upload_image' && is_admin()) {
   header('Content-Type: application/json');
   if (!isset($_FILES['file'])) { echo json_encode(['error' => 'Không tìm thấy file']); exit; }
   $dir = 'uploads/'; if (!is_dir($dir)) mkdir($dir, 0777, true);
   $fileInfo = pathinfo($_FILES['file']['name']); $ext = strtolower($fileInfo['extension']);
   $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'ico']; 
   if (!in_array($ext, $allowed)) { echo json_encode(['error' => 'Chỉ chấp nhận file ảnh (jpg, png, gif, webp, ico)']); exit; }
   if ($_FILES['file']['size'] > 5 * 1024 * 1024) { echo json_encode(['error' => 'File quá lớn (Tối đa 5MB)']); exit; }
   $filepath = $dir . uniqid('img_') . '_' . time() . '.' . $ext;
   if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) { echo json_encode(['url' => $filepath]); } 
   else { echo json_encode(['error' => 'Lưu file thất bại.']); }
   exit;
}

if ($action == 'logout') { session_destroy(); header("Location: index.php"); exit; }

if ($action == 'register' && $_SERVER['REQUEST_METHOD'] == 'POST') {
   verify_csrf();
   $user = trim($_POST['username']); $pass = $_POST['password']; $name = trim($_POST['fullname']);
   $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?"); $stmt->execute([$user]);
   if ($stmt->rowCount() > 0) { $msg = "Tài khoản đã tồn tại!"; $msg_type = 'error'; } 
   else {
       $hashed = password_hash($pass, PASSWORD_BCRYPT);
       $stmt = $pdo->prepare("INSERT INTO users (username, password, fullname) VALUES (?, ?, ?)");
       $stmt->execute([$user, $hashed, $name]);
       $msg = "Đăng ký thành công! Vui lòng đăng nhập."; $action = 'login';
   }
}

if ($action == 'login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
   verify_csrf();
   $user = trim($_POST['username']); $pass = $_POST['password'];
   $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?"); $stmt->execute([$user]);
   $u = $stmt->fetch();
   if ($u && password_verify($pass, $u['password'])) {
       $_SESSION['user_id'] = $u['id']; $_SESSION['username'] = $u['username'];
       $_SESSION['fullname'] = $u['fullname']; $_SESSION['role'] = $u['role'];
       if ($u['role'] === 'admin') { header("Location: index.php?action=admin"); exit; } 
       else { header("Location: index.php"); exit; }
   } else { $msg = "Sai tài khoản hoặc mật khẩu!"; $msg_type = 'error'; }
}

if ($action == 'admin_save_settings' && is_admin() && $_SERVER['REQUEST_METHOD'] == 'POST') {
    verify_csrf();
    $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
    $stmt->execute([$_POST['logo_type'], 'logo_type']);
    $stmt->execute([$_POST['logo_icon'], 'logo_icon']);
    $stmt->execute([$_POST['logo_image'], 'logo_image']);
    $stmt->execute([$_POST['favicon'], 'favicon']);
    
    header("Location: index.php?action=admin_settings&msg=" . urlencode("Lưu cài đặt thành công!")); exit;
}

if ($action == 'admin_toggle_exam' && is_admin() && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pdo->exec("UPDATE exams SET status = IF(status='active', 'inactive', 'active') WHERE id = $id");
    header("Location: index.php?action=admin"); exit;
}
if ($action == 'admin_delete_exam' && is_admin() && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pdo->exec("DELETE FROM exams WHERE id = $id");
    header("Location: index.php?action=admin&msg=Đã xóa đề thi"); exit;
}

if ($action == 'admin_submit_exam' && is_admin() && $_SERVER['REQUEST_METHOD'] == 'POST') {
   verify_csrf();
   try {
       $pdo->beginTransaction();
       $is_edit = !empty($_POST['edit_exam_id']);
       
       if ($is_edit) {
           $exam_id = intval($_POST['edit_exam_id']);
           $stmt = $pdo->prepare("UPDATE exams SET title=?, code=?, duration=?, description=? WHERE id=?");
           $stmt->execute([$_POST['title'], $_POST['code'], $_POST['duration'], $_POST['description'], $exam_id]);
       } else {
           $stmt = $pdo->prepare("INSERT INTO exams (title, code, duration, description) VALUES (?, ?, ?, ?)");
           $stmt->execute([$_POST['title'], $_POST['code'], $_POST['duration'], $_POST['description']]);
           $exam_id = $pdo->lastInsertId();
       }

       for ($i=1; $i<=24; $i++) {
           $content = $_POST["mcq_{$i}_content"];
           $l_content = $_POST["mcq_{$i}_left"] ?? ''; $r_content = $_POST["mcq_{$i}_right"] ?? '';
           
           $show_py = isset($_POST["mcq_{$i}_show_py"]) ? 1 : 0;
           $show_cpp = isset($_POST["mcq_{$i}_show_cpp"]) ? 1 : 0;
           $layout = 'normal';
           if($show_py && $show_cpp) $layout = 'python,cpp';
           elseif($show_py) $layout = 'python';
           elseif($show_cpp) $layout = 'cpp';
           
           $correct_opt = isset($_POST["mcq_{$i}_correct"]) ? $_POST["mcq_{$i}_correct"] : NULL;
           
           if ($is_edit) {
               $q_id = $pdo->query("SELECT id FROM questions WHERE exam_id=$exam_id AND q_index=$i AND q_type='mcq'")->fetchColumn();
               if ($q_id) {
                   $pdo->prepare("UPDATE questions SET content=?, layout=?, left_content=?, right_content=? WHERE id=?")->execute([$content, $layout, $l_content, $r_content, $q_id]);
                   $pdo->prepare("UPDATE answers_mcq SET opt_a=?, opt_b=?, opt_c=?, opt_d=?, correct_opt=? WHERE question_id=?")
                       ->execute([$_POST["mcq_{$i}_a"], $_POST["mcq_{$i}_b"], $_POST["mcq_{$i}_c"], $_POST["mcq_{$i}_d"], $correct_opt, $q_id]);
               } else {
                   $pdo->prepare("INSERT INTO questions (exam_id, q_type, q_index, content, layout, left_content, right_content) VALUES (?, 'mcq', ?, ?, ?, ?, ?)")->execute([$exam_id, $i, $content, $layout, $l_content, $r_content]);
                   $q_id = $pdo->lastInsertId();
                   $pdo->prepare("INSERT INTO answers_mcq (question_id, opt_a, opt_b, opt_c, opt_d, correct_opt) VALUES (?, ?, ?, ?, ?, ?)")
                       ->execute([$q_id, $_POST["mcq_{$i}_a"], $_POST["mcq_{$i}_b"], $_POST["mcq_{$i}_c"], $_POST["mcq_{$i}_d"], $correct_opt]);
               }
           } else {
               $pdo->prepare("INSERT INTO questions (exam_id, q_type, q_index, content, layout, left_content, right_content) VALUES (?, 'mcq', ?, ?, ?, ?, ?)")->execute([$exam_id, $i, $content, $layout, $l_content, $r_content]);
               $q_id = $pdo->lastInsertId();
               $pdo->prepare("INSERT INTO answers_mcq (question_id, opt_a, opt_b, opt_c, opt_d, correct_opt) VALUES (?, ?, ?, ?, ?, ?)")
                   ->execute([$q_id, $_POST["mcq_{$i}_a"], $_POST["mcq_{$i}_b"], $_POST["mcq_{$i}_c"], $_POST["mcq_{$i}_d"], $correct_opt]);
           }
       }

       for ($i=25; $i<=28; $i++) {
           $content = $_POST["tf_{$i}_content"];
           $l_content = $_POST["tf_{$i}_left"] ?? ''; $r_content = $_POST["tf_{$i}_right"] ?? '';
           
           $show_py = isset($_POST["tf_{$i}_show_py"]) ? 1 : 0;
           $show_cpp = isset($_POST["tf_{$i}_show_cpp"]) ? 1 : 0;
           $layout = 'normal';
           if($show_py && $show_cpp) $layout = 'python,cpp';
           elseif($show_py) $layout = 'python';
           elseif($show_cpp) $layout = 'cpp';

           $a_true = isset($_POST["tf_{$i}_a_true"]) ? 1 : 0; $b_true = isset($_POST["tf_{$i}_b_true"]) ? 1 : 0;
           $c_true = isset($_POST["tf_{$i}_c_true"]) ? 1 : 0; $d_true = isset($_POST["tf_{$i}_d_true"]) ? 1 : 0;
           
           if ($is_edit) {
               $q_id = $pdo->query("SELECT id FROM questions WHERE exam_id=$exam_id AND q_index=$i AND q_type='tf'")->fetchColumn();
               if ($q_id) {
                   $pdo->prepare("UPDATE questions SET content=?, layout=?, left_content=?, right_content=? WHERE id=?")->execute([$content, $layout, $l_content, $r_content, $q_id]);
                   $pdo->prepare("UPDATE answers_tf SET part_a=?, is_a_true=?, part_b=?, is_b_true=?, part_c=?, is_c_true=?, part_d=?, is_d_true=? WHERE question_id=?")
                       ->execute([$_POST["tf_{$i}_a"], $a_true, $_POST["tf_{$i}_b"], $b_true, $_POST["tf_{$i}_c"], $c_true, $_POST["tf_{$i}_d"], $d_true, $q_id]);
               } else {
                   $pdo->prepare("INSERT INTO questions (exam_id, q_type, q_index, content, layout, left_content, right_content) VALUES (?, 'tf', ?, ?, ?, ?, ?)")->execute([$exam_id, $i, $content, $layout, $l_content, $r_content]);
                   $q_id = $pdo->lastInsertId();
                   $pdo->prepare("INSERT INTO answers_tf (question_id, part_a, is_a_true, part_b, is_b_true, part_c, is_c_true, part_d, is_d_true) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")
                       ->execute([$q_id, $_POST["tf_{$i}_a"], $a_true, $_POST["tf_{$i}_b"], $b_true, $_POST["tf_{$i}_c"], $c_true, $_POST["tf_{$i}_d"], $d_true]);
               }
           } else {
               $pdo->prepare("INSERT INTO questions (exam_id, q_type, q_index, content, layout, left_content, right_content) VALUES (?, 'tf', ?, ?, ?, ?, ?)")->execute([$exam_id, $i, $content, $layout, $l_content, $r_content]);
               $q_id = $pdo->lastInsertId();
               $pdo->prepare("INSERT INTO answers_tf (question_id, part_a, is_a_true, part_b, is_b_true, part_c, is_c_true, part_d, is_d_true) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")
                   ->execute([$q_id, $_POST["tf_{$i}_a"], $a_true, $_POST["tf_{$i}_b"], $b_true, $_POST["tf_{$i}_c"], $c_true, $_POST["tf_{$i}_d"], $d_true]);
           }
       }

       $pdo->commit(); 
       $msg = $is_edit ? "Đã lưu thay đổi đề thi!" : "Tạo đề thi thành công!";
       header("Location: index.php?action=admin&msg=" . urlencode($msg)); exit;
   } catch (Exception $e) { $pdo->rollBack(); die("Lỗi khi lưu đề: " . $e->getMessage()); }
}

if ($action == 'submit_exam' && is_logged_in() && $_SERVER['REQUEST_METHOD'] == 'POST') {
   verify_csrf();
   $exam_id = intval($_POST['exam_id']); $user_id = $_SESSION['user_id'];
   $ip = $_SERVER['REMOTE_ADDR']; $device = $_SERVER['HTTP_USER_AGENT'];
   
   $stmt = $pdo->prepare("SELECT duration FROM exams WHERE id = ?"); $stmt->execute([$exam_id]);
   $exam = $stmt->fetch(); if(!$exam) die("Đề thi không tồn tại");

   $time_taken = time() - ($_SESSION["exam_start_$exam_id"] ?? time());
   
   $mcq_correct = [];
   $stmt = $pdo->prepare("SELECT q.id, a.correct_opt FROM questions q JOIN answers_mcq a ON q.id = a.question_id WHERE q.exam_id = ?");
   $stmt->execute([$exam_id]); while ($row = $stmt->fetch()) $mcq_correct[$row['id']] = $row['correct_opt'];

   $tf_correct = [];
   $stmt = $pdo->prepare("SELECT q.id, a.is_a_true, a.is_b_true, a.is_c_true, a.is_d_true FROM questions q JOIN answers_tf a ON q.id = a.question_id WHERE q.exam_id = ?");
   $stmt->execute([$exam_id]); while ($row = $stmt->fetch()) { $tf_correct[$row['id']] = ['a' => $row['is_a_true'], 'b' => $row['is_b_true'], 'c' => $row['is_c_true'], 'd' => $row['is_d_true']]; }

   $mcq_score = 0; $tf_score = 0; $details = [];
   $ans_mcq = $_POST['ans_mcq'] ?? [];
   foreach ($mcq_correct as $q_id => $correct_opt) {
       $user_opt = $ans_mcq[$q_id] ?? null; 
       $is_correct = ($correct_opt !== null && $user_opt === $correct_opt) ? 1 : 0;
       $points = $is_correct ? 0.25 : 0; $mcq_score += $points;
       $details[] = ['q_id' => $q_id, 'ans' => $user_opt, 'is_correct' => $is_correct, 'points' => $points];
   }

   $ans_tf = $_POST['ans_tf'] ?? [];
   foreach ($tf_correct as $q_id => $correct) {
       $user_ans = $ans_tf[$q_id] ?? []; $parts_correct = 0;
       $u_a = isset($user_ans['a']) ? ($user_ans['a'] === 'true' ? 1 : 0) : -1;
       $u_b = isset($user_ans['b']) ? ($user_ans['b'] === 'true' ? 1 : 0) : -1;
       $u_c = isset($user_ans['c']) ? ($user_ans['c'] === 'true' ? 1 : 0) : -1;
       $u_d = isset($user_ans['d']) ? ($user_ans['d'] === 'true' ? 1 : 0) : -1;
       
       if ($u_a !== -1 && $u_a == $correct['a']) $parts_correct++; 
       if ($u_b !== -1 && $u_b == $correct['b']) $parts_correct++;
       if ($u_c !== -1 && $u_c == $correct['c']) $parts_correct++; 
       if ($u_d !== -1 && $u_d == $correct['d']) $parts_correct++;

       $points = 0;
       if ($parts_correct == 1) $points = 0.1; elseif ($parts_correct == 2) $points = 0.25;
       elseif ($parts_correct == 3) $points = 0.5; elseif ($parts_correct == 4) $points = 1.0;
       $tf_score += $points;
       $details[] = ['q_id' => $q_id, 'ans' => json_encode(['a'=>$u_a, 'b'=>$u_b, 'c'=>$u_c, 'd'=>$u_d]), 'is_correct' => ($parts_correct == 4 ? 1 : 0), 'points' => $points];
   }

   $total_score = $mcq_score + $tf_score;

   $pdo->beginTransaction();
   $stmt = $pdo->prepare("INSERT INTO results (user_id, exam_id, score, mcq_score, tf_score, time_taken, ip, device) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
   $stmt->execute([$user_id, $exam_id, $total_score, $mcq_score, $tf_score, $time_taken, $ip, $device]);
   $result_id = $pdo->lastInsertId();

   $stmtD = $pdo->prepare("INSERT INTO result_details (result_id, question_id, user_answer, is_correct, points) VALUES (?, ?, ?, ?, ?)");
   foreach ($details as $d) { $stmtD->execute([$result_id, $d['q_id'], $d['ans'], $d['is_correct'], $d['points']]); }
   $pdo->commit();

   unset($_SESSION["exam_start_$exam_id"]);
   unset($_SESSION["exam_order_$exam_id"]);
   
   header("Location: index.php?action=result&id=$result_id"); exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
   <title>Thi Tin Học - BINHSUBVIP</title>
   
   <link rel="manifest" href="manifest.json">
   <meta name="theme-color" content="#4f46e5">
   <meta name="apple-mobile-web-app-capable" content="yes">
   <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
   <meta name="apple-mobile-web-app-title" content="Thi Tin Học">
   <link rel="apple-touch-icon" href="<?= !empty($site_settings['favicon']) ? htmlspecialchars($site_settings['favicon']) : 'icon-192.png' ?>">

   <?php if (!empty($site_settings['favicon'])): ?>
       <link rel="icon" href="<?= htmlspecialchars($site_settings['favicon']) ?>">
   <?php endif; ?>

   <script src="https://cdn.tailwindcss.com"></script>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
   <script>
       tailwind.config = {
           theme: {
               extend: {
                   colors: { primary: '#4f46e5', secondary: '#4338ca', accent: '#ec4899', bg_light: '#f8fafc' },
                   fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'], }
               }
           }
       }
   </script>
   <style>
       @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
       html { -webkit-overflow-scrolling: touch; }
       body { background-color: #f8fafc; overflow-x: hidden; }
       .dual-code pre { background: #1e293b; color: #e2e8f0; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; font-family: monospace; font-size: 0.875rem; }
       .glass-panel { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
       .noselect { -webkit-user-select: none; -ms-user-select: none; user-select: none; }
       ::-webkit-scrollbar { width: 6px; height: 6px; }
       ::-webkit-scrollbar-track { background: #f1f5f9; }
       ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
       ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
       .break-words { word-break: break-word; overflow-wrap: break-word; }
       .preview-img-in-input img { max-height: 120px; border-radius: 8px; margin-top: 8px; border: 2px solid #e2e8f0; display: inline-block; }
       .custom-scrollbar::-webkit-scrollbar { width: 4px; }
   </style>
</head>
<body class="text-slate-800 antialiased min-h-screen flex flex-col font-sans">

<nav class="bg-primary text-white shadow-lg sticky top-0 z-50 transform-gpu">
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
       <div class="flex justify-between items-center h-16">
           <a href="index.php" class="flex items-center gap-2 text-lg sm:text-xl font-bold tracking-tight truncate">
               <div class="bg-white/20 p-2 rounded-lg flex items-center justify-center backdrop-blur-sm w-10 h-10 overflow-hidden">
                   <?php if (($site_settings['logo_type'] ?? 'icon') === 'icon'): ?>
                       <i class="<?= htmlspecialchars($site_settings['logo_icon'] ?? 'fa-solid fa-laptop-code') ?> text-white text-xl"></i>
                   <?php elseif (!empty($site_settings['logo_image'])): ?>
                       <img src="<?= htmlspecialchars($site_settings['logo_image']) ?>" class="max-w-full max-h-full object-contain" alt="Logo">
                   <?php else: ?>
                       <i class="fa-solid fa-laptop-code text-white text-xl"></i>
                   <?php endif; ?>
               </div>
               <span class="truncate hidden sm:inline">Thi Tin Học Ứng Dụng Máy Tính</span>
               <span class="truncate sm:hidden">Thi Tin Học</span>
           </a>
           <div class="flex items-center gap-2 sm:gap-4">
               <?php if (is_logged_in()): ?>
                   <?php if (is_admin()): ?>
                       <a href="?action=admin" class="hidden sm:flex items-center gap-1 hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition"><i class="fa-solid fa-gauge-high"></i> Quản trị</a>
                       <a href="?action=admin" class="sm:hidden text-white hover:bg-white/10 p-2 rounded-lg transition"><i class="fa-solid fa-gauge-high text-lg"></i></a>
                   <?php endif; ?>
                   <div class="hidden sm:flex items-center gap-2 font-medium text-sm bg-black/10 px-3 py-1.5 rounded-full border border-white/10">
                       <i class="fa-solid fa-circle-user text-lg text-indigo-200"></i> <span class="truncate max-w-[150px]"><?= htmlspecialchars($_SESSION['fullname']) ?></span>
                   </div>
                   <a href="?action=logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition shadow-sm flex items-center gap-2"><i class="fa-solid fa-power-off"></i> <span class="hidden sm:inline">Thoát</span></a>
               <?php else: ?>
                   <a href="?action=login" class="hover:text-indigo-200 font-medium px-2 py-2">Đăng nhập</a>
                   <a href="?action=register" class="bg-white text-primary px-4 py-2 rounded-lg font-bold hover:bg-indigo-50 shadow-sm transition">Đăng ký</a>
               <?php endif; ?>
           </div>
       </div>
   </div>
</nav>

<main class="flex-grow flex flex-col items-center w-full">
<?php
$get_msg = $_GET['msg'] ?? $msg;
if ($get_msg) {
   $color = $msg_type == 'error' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200';
   $icon = $msg_type == 'error' ? 'fa-circle-xmark' : 'fa-circle-check';
   echo "<div class='w-full max-w-md mx-auto mt-6 px-4'><div class='p-4 rounded-xl border $color flex items-center gap-3 shadow-sm'><i class='fa-solid $icon text-xl'></i><span class='font-medium'>".htmlspecialchars($get_msg)."</span></div></div>";
}

if (!is_logged_in() && in_array($action, ['login', 'register', 'home'])): 
   $is_reg = ($action == 'register');
?>
   <div class="flex flex-col items-center justify-center flex-grow py-12 px-4 w-full">
       <div class="text-center mb-8 max-w-2xl px-4">
           <h1 class="text-3xl font-black text-primary mb-3">Hệ Thống Thi Tin Học Ứng Dụng</h1>
           <p class="text-slate-500 font-medium">Nền tảng thi trắc nghiệm trực tuyến chuyên nghiệp. Đăng nhập để bắt đầu.</p>
       </div>
       <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl w-full max-w-md border border-slate-100 relative overflow-hidden">
           <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary to-accent"></div>
           <div class="text-center mb-8">
               <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 text-primary mb-4"><i class="fa-solid <?= $is_reg ? 'fa-user-plus' : 'fa-right-to-bracket' ?> text-3xl"></i></div>
               <h2 class="text-2xl font-extrabold text-slate-800"><?= $is_reg ? 'Tạo Tài Khoản Mới' : 'Đăng Nhập Hệ Thống' ?></h2>
           </div>
           <form method="POST" action="?action=<?= $is_reg ? 'register' : 'login' ?>" class="space-y-5">
               <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
               <?php if($is_reg): ?>
                   <div><div class="relative"><div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fa-regular fa-id-card text-slate-400"></i></div><input type="text" name="fullname" required placeholder="Họ và Tên" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all"></div></div>
               <?php endif; ?>
               <div><div class="relative"><div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fa-regular fa-user text-slate-400"></i></div><input type="text" name="username" required placeholder="Tên đăng nhập" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all"></div></div>
               <div><div class="relative"><div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fa-solid fa-lock text-slate-400"></i></div><input type="password" name="password" required placeholder="Mật khẩu" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all"></div></div>
               <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary/30 transition-all duration-200 mt-2"><?= $is_reg ? 'Đăng Ký Ngay' : 'Đăng Nhập' ?></button>
           </form>
           <div class="mt-8 text-center text-sm text-slate-500 border-t border-slate-100 pt-6"><?= $is_reg ? 'Đã có tài khoản?' : 'Chưa có tài khoản?' ?> <a href="?action=<?= $is_reg ? 'login' : 'register' ?>" class="text-primary font-bold hover:text-secondary hover:underline ml-1"><?= $is_reg ? 'Đăng nhập tại đây' : 'Tạo ngay' ?></a></div>
       </div>
   </div>

<?php 
elseif (is_logged_in() && $action == 'home' && !is_admin()): 
   $stmt = $pdo->prepare("SELECT COUNT(*) as total, MAX(score) as max_score FROM results WHERE user_id = ?"); $stmt->execute([$_SESSION['user_id']]); $stats = $stmt->fetch();
   $stmt = $pdo->prepare("SELECT r.*, e.title FROM results r JOIN exams e ON r.exam_id = e.id WHERE r.user_id = ? ORDER BY r.created_at DESC"); $stmt->execute([$_SESSION['user_id']]); $history = $stmt->fetchAll();
   $exams = $pdo->query("SELECT * FROM exams WHERE status = 'active' ORDER BY id DESC")->fetchAll();
?>
   <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 w-full">
       <div class="bg-gradient-to-r from-primary to-secondary rounded-3xl p-8 sm:p-10 mb-8 text-white shadow-xl relative overflow-hidden">
           <div class="absolute inset-0 bg-black opacity-10"></div>
           <div class="relative z-10">
               <h2 class="text-3xl md:text-4xl font-black mb-3">Sẵn sàng thử sức với bài thi tin học?</h2>
               <p class="text-indigo-100 text-lg max-w-2xl mb-6">Nền tảng kiểm tra, đánh giá năng lực tin học ứng dụng hiện đại. Giúp bạn rèn luyện kiến thức nhanh chóng.</p>
               <div class="flex items-center gap-4"><div class="bg-white/20 backdrop-blur px-4 py-2 rounded-lg font-medium">Xin chào, <?= htmlspecialchars($_SESSION['fullname']) ?> 👋</div></div>
           </div>
           <i class="fa-solid fa-graduation-cap absolute -bottom-10 -right-10 text-[200px] opacity-20 transform -rotate-12"></i>
       </div>

       <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
           <div class="lg:col-span-1 space-y-4">
               <div class="flex items-center gap-2 mb-4"><i class="fa-solid fa-fire text-orange-500 text-xl"></i><h2 class="text-xl font-bold text-slate-800">Đề Thi Mới Nhất</h2></div>
               <div class="grid gap-4">
                   <?php foreach($exams as $e): ?>
                   <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 hover:border-primary/50 hover:shadow-md transition-all group">
                       <div class="flex justify-between items-start mb-2"><span class="bg-indigo-50 text-primary text-xs font-bold px-2 py-1 rounded">Mã: <?= htmlspecialchars($e['code']) ?></span><span class="text-slate-500 text-sm font-medium"><i class="fa-regular fa-clock mr-1"></i><?= $e['duration'] ?>p</span></div>
                       <h3 class="font-bold text-lg mb-2 text-slate-800 group-hover:text-primary transition-colors"><?= htmlspecialchars($e['title']) ?></h3>
                       <p class="text-sm text-slate-500 mb-5 line-clamp-2"><?= htmlspecialchars($e['description']) ?: 'Mời bạn tham gia làm bài thi này.' ?></p>
                       <a href="?action=take_exam&id=<?= $e['id'] ?>" class="block w-full text-center bg-slate-900 hover:bg-primary text-white py-2.5 rounded-xl font-bold transition-colors">Vào thi ngay <i class="fa-solid fa-arrow-right ml-1"></i></a>
                   </div>
                   <?php endforeach; ?>
                   <?php if(empty($exams)): ?><div class="bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-500"><i class="fa-regular fa-folder-open text-4xl mb-3 text-slate-300"></i><p>Hiện tại chưa có đề thi nào mở.</p></div><?php endif; ?>
               </div>
           </div>

           <div class="lg:col-span-2">
               <div class="grid grid-cols-2 gap-4 mb-6">
                   <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between"><div><div class="text-sm text-slate-500 font-medium mb-1">Tổng bài đã nộp</div><div class="text-3xl font-black text-slate-800"><?= $stats['total'] ?></div></div><div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-primary text-xl"><i class="fa-solid fa-file-contract"></i></div></div>
                   <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between"><div><div class="text-sm text-emerald-600 font-medium mb-1">Điểm cao nhất</div><div class="text-3xl font-black text-emerald-600"><?= number_format((float)$stats['max_score'], 1) ?></div></div><div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-500 text-xl"><i class="fa-solid fa-ranking-star"></i></div></div>
               </div>

               <div class="flex items-center gap-2 mb-4"><i class="fa-solid fa-clock-rotate-left text-slate-400 text-xl"></i><h2 class="text-xl font-bold text-slate-800">Lịch Sử Làm Bài</h2></div>
               <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                   <div class="overflow-x-auto">
                       <table class="min-w-full divide-y divide-slate-200">
                           <thead class="bg-slate-50"><tr><th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Tên đề thi</th><th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Điểm số</th><th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Ngày nộp</th><th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Hành động</th></tr></thead>
                           <tbody class="divide-y divide-slate-100">
                               <?php foreach($history as $h): ?>
                               <tr class="hover:bg-slate-50">
                                   <td class="px-6 py-4"><div class="font-bold text-slate-800"><?= htmlspecialchars($h['title']) ?></div><div class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-stopwatch mr-1"></i><?= round($h['time_taken']/60) ?> phút</div></td>
                                   <td class="px-6 py-4 text-center"><div class="inline-flex items-center justify-center w-10 h-10 rounded-full border-2 <?= $h['score'] >= 5 ? 'border-emerald-500 text-emerald-600 bg-emerald-50' : 'border-red-500 text-red-600 bg-red-50' ?> font-black text-base"><?= number_format($h['score'], 1) ?></div></td>
                                   <td class="px-6 py-4 text-center text-sm text-slate-500 font-medium"><?= date('d/m/Y H:i', strtotime($h['created_at'])) ?></td>
                                   <td class="px-6 py-4 text-right text-sm"><a href="?action=result&id=<?= $h['id'] ?>" class="bg-white border border-slate-200 hover:text-primary text-slate-600 px-3 py-1.5 rounded-lg font-medium transition shadow-sm">Chi tiết</a></td>
                               </tr>
                               <?php endforeach; ?>
                           </tbody>
                       </table>
                       <?php if(empty($history)): ?><div class="p-12 text-center text-slate-400"><i class="fa-solid fa-folder-open text-5xl mb-4 opacity-30"></i><p class="font-medium text-slate-500">Chưa có lịch sử làm bài</p></div><?php endif; ?>
                   </div>
               </div>
           </div>
       </div>
   </div>

<?php
elseif (is_logged_in() && $action == 'take_exam' && isset($_GET['id'])):
   $exam_id = intval($_GET['id']);
   $stmt = $pdo->prepare("SELECT * FROM exams WHERE id = ?"); $stmt->execute([$exam_id]); $exam = $stmt->fetch(); if(!$exam) die("Đề thi không tồn tại!");
   if(!isset($_SESSION["exam_start_$exam_id"])) { $_SESSION["exam_start_$exam_id"] = time(); }
   
   $stmt = $pdo->prepare("SELECT q.*, am.opt_a, am.opt_b, am.opt_c, am.opt_d, at.part_a, at.part_b, at.part_c, at.part_d FROM questions q LEFT JOIN answers_mcq am ON q.id = am.question_id LEFT JOIN answers_tf at ON q.id = at.question_id WHERE q.exam_id = ? ORDER BY q.q_index ASC");
   $stmt->execute([$exam_id]); 
   $questions_raw = $stmt->fetchAll();
   
   $session_order_key = "exam_order_$exam_id";

   if (!isset($_SESSION[$session_order_key])) {
       $mcq_qs = [];
       $tf_qs = [];
       foreach($questions_raw as $q) {
           if ($q['q_type'] == 'mcq') $mcq_qs[] = $q;
           else $tf_qs[] = $q;
       }
       
       shuffle($mcq_qs);
       shuffle($tf_qs);
       
       $shuffled_qs = array_merge($mcq_qs, $tf_qs);
       
       $ans_order = [];
       foreach($shuffled_qs as $q) {
           if ($q['q_type'] == 'mcq') {
               $k = ['A','B','C','D']; shuffle($k);
               $ans_order[$q['id']] = $k;
           } else {
               $k = ['a','b','c','d']; shuffle($k);
               $ans_order[$q['id']] = $k;
           }
       }
       
       $_SESSION[$session_order_key] = [
           'questions' => $shuffled_qs,
           'answers' => $ans_order
       ];
   }

   $questions = $_SESSION[$session_order_key]['questions'];
   $ans_order = $_SESSION[$session_order_key]['answers'];
?>
   <script> document.addEventListener('contextmenu', event => event.preventDefault()); document.onkeydown = function(e) { if(e.keyCode == 123 || (e.ctrlKey && e.shiftKey && (e.keyCode == 'I'.charCodeAt(0) || e.keyCode == 'J'.charCodeAt(0))) || (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) || (e.ctrlKey && e.keyCode == 'C'.charCodeAt(0))) { return false; } } </script>
   
   <div class="max-w-7xl mx-auto w-full px-2 sm:px-4 lg:px-8 py-6 noselect relative preview-img-in-input">
       <form id="examForm" method="POST" action="?action=submit_exam" class="flex flex-col lg:flex-row gap-6 items-start relative">
           <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
           <input type="hidden" name="exam_id" value="<?= $exam['id'] ?>">
           
           <div class="w-full lg:w-1/4 lg:order-2 lg:sticky lg:top-20 z-10 hidden lg:block">
               <div class="glass-panel bg-white/90 rounded-2xl shadow-lg border border-slate-200 p-5 flex flex-col lg:h-[calc(100vh-8rem)]">
                   <div class="text-center mb-6 pb-5 border-b border-slate-100">
                       <div class="text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">Thời gian còn lại</div>
                       <div id="timer_desktop" class="text-4xl font-black text-rose-500 font-mono tracking-wider drop-shadow-sm transition-colors">--:--</div>
                   </div>
                   <div class="flex-grow overflow-y-auto pr-2 custom-scrollbar">
                       <div class="text-xs font-bold text-primary mb-2">Trắc nghiệm (1-24)</div>
                       <div class="grid grid-cols-4 gap-2 mb-5">
                           <?php for($i=1; $i<=24; $i++): ?> <button type="button" onclick="scrollToQ(<?= $i ?>)" id="btn_nav_<?= $i ?>" class="nav-btn w-full aspect-square rounded-lg border border-slate-300 font-bold text-slate-600 hover:bg-slate-100 text-sm flex items-center justify-center"><?= $i ?></button> <?php endfor; ?>
                       </div>
                       <div class="text-xs font-bold text-purple-600 mb-2 pt-3 border-t border-slate-100">Đúng/Sai (25-28)</div>
                       <div class="grid grid-cols-4 gap-2">
                           <?php for($i=25; $i<=28; $i++): ?> <button type="button" onclick="scrollToQ(<?= $i ?>)" id="btn_nav_<?= $i ?>" class="nav-btn w-full aspect-square rounded-lg border border-slate-300 font-bold text-slate-600 hover:bg-slate-100 text-sm flex items-center justify-center"><?= $i ?></button> <?php endfor; ?>
                       </div>
                   </div>
                   <div class="mt-4 pt-4 border-t border-slate-100">
                       <button type="button" onclick="confirmSubmit()" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-xl shadow-lg flex items-center justify-center text-lg"><i class="fa-solid fa-paper-plane mr-2"></i> NỘP BÀI THI</button>
                   </div>
               </div>
           </div>

           <div class="w-full lg:w-3/4 lg:order-1 flex flex-col gap-6">
               
               <div class="lg:hidden sticky top-[72px] z-40 bg-white border border-slate-200 shadow-md px-4 py-3 flex justify-between items-center rounded-2xl transform-gpu">
                   <div class="flex flex-col">
                       <span class="text-[10px] font-bold text-slate-500 uppercase leading-tight">Thời gian</span>
                       <span id="timer_mobile" class="text-2xl font-black text-rose-600 font-mono leading-none">--:--</span>
                   </div>
                   <button type="button" onclick="confirmSubmit()" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm flex items-center text-base active:scale-95 transition-transform"><i class="fa-solid fa-paper-plane mr-2"></i> Nộp Bài</button>
               </div>

               <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8 text-center relative overflow-hidden">
                   <div class="absolute top-0 left-0 w-2 h-full bg-primary"></div>
                   <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 mb-2"><?= htmlspecialchars($exam['title']) ?></h1>
                   <div class="flex flex-wrap justify-center gap-3 text-sm font-medium text-slate-500">
                       <span class="bg-slate-100 px-3 py-1 rounded-full"><i class="fa-solid fa-barcode mr-1"></i> <?= htmlspecialchars($exam['code']) ?></span>
                       <span class="bg-slate-100 px-3 py-1 rounded-full"><i class="fa-regular fa-clock mr-1"></i> <?= $exam['duration'] ?> phút</span>
                   </div>
               </div>

               <?php foreach($questions as $idx => $q): 
                   $display_index = $idx + 1;
                   $layout = $q['layout'] ?? 'normal';
                   $has_py = strpos($layout, 'python') !== false;
                   $has_cpp = strpos($layout, 'cpp') !== false;
               ?>
                   <div id="q_<?= $display_index ?>" class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-7 shadow-sm scroll-mt-24">
                       <div class="flex flex-col sm:flex-row gap-4 mb-4 sm:mb-6">
                           <div class="shrink-0 flex items-center border-b sm:border-0 pb-3 sm:pb-0">
                               <span class="bg-gradient-to-br from-primary to-secondary text-white font-black rounded-xl w-10 h-10 flex items-center justify-center shadow-md"><?= $display_index ?></span>
                           </div>
                           <div class="w-full min-w-0">
                               <?php if($has_py || $has_cpp): ?>
                                   <div class="grid grid-cols-1 <?= ($has_py && $has_cpp) ? 'xl:grid-cols-2' : '' ?> gap-4 mb-5">
                                       <?php if($has_py): ?>
                                           <div class="relative prose max-w-none text-sm sm:text-base text-slate-800 bg-slate-50 p-4 pt-8 rounded-xl border border-slate-200 overflow-x-auto whitespace-pre-wrap font-mono"><span class="absolute top-0 left-0 bg-indigo-100 text-indigo-700 text-[10px] font-bold px-3 py-1 rounded-br-lg rounded-tl-xl uppercase"><i class="fa-brands fa-python"></i> Ngôn Ngữ Python</span><?= render_text($q['left_content'] ?? '') ?></div>
                                       <?php endif; ?>
                                       <?php if($has_cpp): ?>
                                           <div class="relative prose max-w-none text-sm sm:text-base text-slate-800 bg-slate-50 p-4 pt-8 rounded-xl border border-slate-200 overflow-x-auto whitespace-pre-wrap font-mono"><span class="absolute top-0 left-0 bg-amber-100 text-amber-700 text-[10px] font-bold px-3 py-1 rounded-br-lg rounded-tl-xl uppercase"><i class="fa-solid fa-code"></i> Ngôn Ngữ C++</span><?= render_text($q['right_content'] ?? '') ?></div>
                                       <?php endif; ?>
                                   </div>
                               <?php endif; ?>
                               <div class="text-base sm:text-lg font-medium text-slate-800 prose max-w-none break-words leading-relaxed whitespace-pre-wrap"><?= render_text($q['content'] ?? '') ?></div>
                           </div>
                       </div>

                       <div class="pl-0 sm:pl-14">
                           <?php if($q['q_type'] == 'mcq'): ?>
                               <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                                   <?php 
                                       $options = ['A'=>$q['opt_a'], 'B'=>$q['opt_b'], 'C'=>$q['opt_c'], 'D'=>$q['opt_d']];
                                       $orig_keys = $ans_order[$q['id']];
                                       $labels = ['A', 'B', 'C', 'D'];
                                       
                                       foreach($orig_keys as $i => $orig_key): 
                                           $val = $options[$orig_key];
                                           $label = $labels[$i];
                                   ?>
                                       <label class="group flex items-start p-3 sm:p-4 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-primary/50 transition-all has-[:checked]:border-primary has-[:checked]:bg-indigo-50 has-[:checked]:shadow-md" onclick="markDone(<?= $display_index ?>)">
                                           <div class="pt-0.5 shrink-0">
                                               <input type="radio" name="ans_mcq[<?= $q['id'] ?>]" value="<?= $orig_key ?>" class="w-5 h-5 text-primary border-slate-300 focus:ring-primary cursor-pointer peer">
                                           </div>
                                           <div class="ml-3 flex flex-grow items-start text-left min-w-0">
                                               <span class="font-bold text-slate-700 peer-checked:text-primary mr-2 shrink-0 pt-0.5"><?= $label ?>.</span>
                                               <div class="text-sm sm:text-base text-slate-700 break-words whitespace-pre-wrap leading-relaxed w-full min-w-0"><?= render_text($val ?? '') ?></div>
                                           </div>
                                       </label>
                                   <?php endforeach; ?>
                               </div>
                           <?php elseif($q['q_type'] == 'tf'): ?>
                               <div class="w-full rounded-xl border border-slate-200 overflow-hidden">
                                   <table class="w-full text-sm sm:text-base text-left table-fixed">
                                       <thead class="bg-slate-50 border-b border-slate-200">
                                           <tr>
                                               <th class="p-2 text-center w-[10%] sm:w-[8%]">Ý</th>
                                               <th class="p-2 w-[50%] sm:w-[62%]">Nội dung</th>
                                               <th class="p-1 sm:p-2 text-center text-emerald-600 w-[20%] sm:w-[15%]">Đúng</th>
                                               <th class="p-1 sm:p-2 text-center text-rose-600 w-[20%] sm:w-[15%]">Sai</th>
                                           </tr>
                                       </thead>
                                       <tbody class="divide-y divide-slate-100">
                                           <?php 
                                               $parts = ['a'=>$q['part_a'], 'b'=>$q['part_b'], 'c'=>$q['part_c'], 'd'=>$q['part_d']];
                                               $orig_keys = $ans_order[$q['id']];
                                               $labels = ['a', 'b', 'c', 'd'];
                                               
                                               foreach($orig_keys as $i => $orig_key): 
                                                   $val = $parts[$orig_key];
                                                   $label = $labels[$i];
                                           ?>
                                           <tr class="hover:bg-slate-50">
                                               <td class="p-2 text-center font-black text-slate-500 uppercase align-middle"><?= $label ?>)</td>
                                               <td class="p-2 text-slate-700 break-words align-middle leading-relaxed whitespace-pre-wrap text-left"><?= render_text($val ?? '') ?></td>
                                               <td class="p-1 sm:p-2 text-center align-middle"><input type="radio" name="ans_tf[<?= $q['id'] ?>][<?= $orig_key ?>]" value="true" class="w-5 h-5 sm:w-6 sm:h-6 text-emerald-500 cursor-pointer" onclick="markDone(<?= $display_index ?>)"></td>
                                               <td class="p-1 sm:p-2 text-center align-middle"><input type="radio" name="ans_tf[<?= $q['id'] ?>][<?= $orig_key ?>]" value="false" class="w-5 h-5 sm:w-6 sm:h-6 text-rose-500 cursor-pointer" onclick="markDone(<?= $display_index ?>)"></td>
                                           </tr>
                                           <?php endforeach; ?>
                                       </tbody>
                                   </table>
                               </div>
                           <?php endif; ?>
                       </div>
                   </div>
               <?php endforeach; ?>
           </div>
       </form>
   </div>
   <script>
       let timeLeft = <?= $exam['duration'] ?> * 60; 
       let timerDesktop = document.getElementById('timer_desktop');
       let timerMobile = document.getElementById('timer_mobile');
       
       function updateTimer() {
           let m = Math.floor(timeLeft / 60); let s = timeLeft % 60;
           let timeStr = (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
           if(timerDesktop) timerDesktop.innerText = timeStr;
           if(timerMobile) timerMobile.innerText = timeStr;
           
           if(timeLeft <= 300) { 
               if(timerDesktop) timerDesktop.classList.add('text-rose-600', 'animate-pulse'); 
               if(timerMobile) timerMobile.classList.add('text-rose-600', 'animate-pulse'); 
           }
           if (timeLeft <= 0) { clearInterval(timerInterval); alert("Đã hết thời gian! Tự động nộp bài."); document.getElementById('examForm').submit(); }
           timeLeft--;
       }
       let timerInterval = setInterval(updateTimer, 1000); updateTimer();
       
       function scrollToQ(idx) { let el = document.getElementById('q_' + idx); if(el) { el.scrollIntoView({behavior: "smooth", block: "center"}); el.classList.add('ring-4', 'ring-primary/50'); setTimeout(() => el.classList.remove('ring-4', 'ring-primary/50'), 1000); } }
       function markDone(idx) { let btn = document.getElementById('btn_nav_' + idx); if(btn) { btn.classList.remove('border-slate-300', 'text-slate-600', 'hover:bg-slate-100'); btn.classList.add('bg-primary', 'text-white', 'border-primary', 'shadow-md'); } }
       function confirmSubmit() { let totalDone = document.querySelectorAll('.nav-btn.bg-primary').length; let msg = totalDone < 28 ? `Bạn mới làm ${totalDone}/28 câu.\nXác nhận nộp bài sớm?` : "Xác nhận nộp bài thi?"; if(confirm(msg)) { document.getElementById('examForm').submit(); } }
   </script>

<?php
elseif (is_logged_in() && $action == 'result' && isset($_GET['id'])):
   $res_id = intval($_GET['id']);
   $stmt = $pdo->prepare("SELECT * FROM results WHERE id = ? AND (user_id = ? OR ? = 'admin')"); $stmt->execute([$res_id, $_SESSION['user_id'], $_SESSION['role']]); $res = $stmt->fetch(); if(!$res) die("Không tìm thấy kết quả.");
   $exam_id = $res['exam_id']; $stmt = $pdo->prepare("SELECT * FROM exams WHERE id = ?"); $stmt->execute([$exam_id]); $exam = $stmt->fetch();
   $stmt = $pdo->prepare("SELECT rd.*, q.q_type, q.q_index, q.content, q.left_content, q.right_content, q.layout, am.opt_a, am.opt_b, am.opt_c, am.opt_d, am.correct_opt, at.part_a, at.part_b, at.part_c, at.part_d, at.is_a_true, at.is_b_true, at.is_c_true, at.is_d_true FROM result_details rd JOIN questions q ON rd.question_id = q.id LEFT JOIN answers_mcq am ON q.id = am.question_id LEFT JOIN answers_tf at ON q.id = at.question_id WHERE rd.result_id = ? ORDER BY q.q_index ASC");
   $stmt->execute([$res_id]); $details = $stmt->fetchAll(); $is_pass = $res['score'] >= 5;
?>
   <div class="max-w-5xl mx-auto w-full px-4 sm:px-6 py-8 preview-img-in-input">
       <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-10 border border-slate-100">
           <div class="p-8 sm:p-12 text-center bg-gradient-to-b <?= $is_pass ? 'from-emerald-50 to-white' : 'from-rose-50 to-white' ?>">
               <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-6 <?= $is_pass ? 'bg-emerald-100 text-emerald-500' : 'bg-rose-100 text-rose-500' ?>"><i class="fa-solid <?= $is_pass ? 'fa-trophy' : 'fa-face-frown-open' ?> text-4xl"></i></div>
               <h1 class="text-3xl sm:text-4xl font-black text-slate-800 mb-3 tracking-tight">Kết Quả Bài Làm</h1>
               <p class="text-lg text-slate-500 font-medium mb-8"><?= htmlspecialchars($exam['title']) ?></p>
               <div class="text-6xl font-black <?= $is_pass ? 'text-emerald-600' : 'text-rose-600' ?> mb-8"><?= number_format($res['score'], 1) ?><span class="text-xl opacity-50">/10</span></div>
               
               <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-left max-w-3xl mx-auto">
                   <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 text-center"><div class="text-xs text-slate-400 uppercase font-bold mb-1">Trắc nghiệm</div><div class="text-xl font-bold text-slate-800"><?= number_format($res['mcq_score'], 2) ?> đ</div></div>
                   <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 text-center"><div class="text-xs text-slate-400 uppercase font-bold mb-1">Đúng/Sai</div><div class="text-xl font-bold text-slate-800"><?= number_format($res['tf_score'], 2) ?> đ</div></div>
                   <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 text-center"><div class="text-xs text-slate-400 uppercase font-bold mb-1">Thời gian</div><div class="text-lg font-bold text-slate-800 mt-1"><?= round($res['time_taken']/60, 1) ?>p</div></div>
                   <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 text-center"><div class="text-xs text-slate-400 uppercase font-bold mb-1">Hoàn thành</div><div class="text-sm font-bold text-slate-800"><?= date('d/m/Y', strtotime($res['created_at'])) ?></div></div>
               </div>
           </div>
       </div>

       <div class="flex items-center gap-3 mb-6"><h2 class="text-2xl font-bold text-slate-800">Chi tiết đáp án</h2><div class="h-px bg-slate-200 flex-grow"></div></div>
       <div class="space-y-6">
           <?php foreach($details as $d): 
               $layout = $d['layout'] ?? 'normal';
               $has_py = strpos($layout, 'python') !== false;
               $has_cpp = strpos($layout, 'cpp') !== false;
           ?>
               <?php 
                   $borderColor = 'border-slate-200'; $bgColor = 'bg-white'; $iconHtml = '';
                   if($d['is_correct'] || $d['points'] == 1) { $borderColor = 'border-emerald-400'; $iconHtml = '<span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1"><i class="fa-solid fa-check-circle"></i> ĐÚNG (+'.$d['points'].')</span>'; } 
                   elseif($d['points'] > 0) { $borderColor = 'border-amber-400'; $iconHtml = '<span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1"><i class="fa-solid fa-star-half-stroke"></i> 1 PHẦN (+'.$d['points'].')</span>'; } 
                   else { $borderColor = 'border-rose-400'; $bgColor = 'bg-rose-50/30'; $iconHtml = '<span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1"><i class="fa-solid fa-xmark-circle"></i> SAI (0đ)</span>'; }
               ?>
               <div class="<?= $bgColor ?> rounded-2xl shadow-sm border border-l-4 <?= $borderColor ?> p-4 sm:p-6 relative">
                   <div class="flex justify-between items-start mb-4"><h3 class="font-bold text-lg text-slate-800">Câu <?= $d['q_index'] ?></h3><?= $iconHtml ?></div>
                   
                   <?php if($has_py || $has_cpp): ?>
                       <div class="grid grid-cols-1 <?= ($has_py && $has_cpp) ? 'xl:grid-cols-2' : '' ?> gap-4 mb-4">
                           <?php if($has_py): ?>
                               <div class="relative prose max-w-none text-sm sm:text-base text-slate-800 bg-slate-50 p-4 pt-8 rounded-xl border border-slate-200 overflow-x-auto whitespace-pre-wrap font-mono"><span class="absolute top-0 left-0 bg-indigo-100 text-indigo-700 text-[10px] font-bold px-3 py-1 rounded-br-lg rounded-tl-xl uppercase"><i class="fa-brands fa-python"></i> Ngôn Ngữ Python</span><?= render_text($d['left_content'] ?? '') ?></div>
                           <?php endif; ?>
                           <?php if($has_cpp): ?>
                               <div class="relative prose max-w-none text-sm sm:text-base text-slate-800 bg-slate-50 p-4 pt-8 rounded-xl border border-slate-200 overflow-x-auto whitespace-pre-wrap font-mono"><span class="absolute top-0 left-0 bg-amber-100 text-amber-700 text-[10px] font-bold px-3 py-1 rounded-br-lg rounded-tl-xl uppercase"><i class="fa-solid fa-code"></i> Ngôn Ngữ C++</span><?= render_text($d['right_content'] ?? '') ?></div>
                           <?php endif; ?>
                       </div>
                   <?php endif; ?>
                   
                   <div class="prose max-w-none text-slate-700 mb-5 text-sm sm:text-base bg-slate-50 p-4 rounded-xl border border-slate-100 whitespace-pre-wrap"><?= render_text($d['content'] ?? '') ?></div>
                   
                   <?php if($d['q_type'] == 'mcq'): ?>
                       <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm sm:text-base">
                           <?php foreach(['A'=>$d['opt_a'], 'B'=>$d['opt_b'], 'C'=>$d['opt_c'], 'D'=>$d['opt_d']] as $k => $v): 
                               $is_user_choice = ($d['user_answer'] == $k); $is_actual_correct = ($d['correct_opt'] == $k);
                               $wrapClass = "border-slate-200 bg-white text-slate-600 opacity-70"; $badgeHtml = "";
                               if($is_actual_correct) { $wrapClass = "border-emerald-500 bg-emerald-50 text-emerald-900 shadow-sm ring-1 ring-emerald-500 opacity-100"; $badgeHtml = "<span class='absolute -top-2.5 -right-2 bg-emerald-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full'>ĐÁP ÁN</span>"; } 
                               elseif($is_user_choice && !$is_actual_correct) { $wrapClass = "border-rose-400 bg-rose-50 text-rose-900 opacity-100"; $badgeHtml = "<span class='absolute -top-2.5 -right-2 bg-rose-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full'>BẠN SAI</span>"; } 
                               elseif($is_user_choice && $is_actual_correct) { $badgeHtml = "<span class='absolute -top-2.5 -right-2 bg-emerald-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full'><i class='fa-solid fa-check'></i> ĐÚNG</span>"; }
                           ?>
                               <div class="relative p-3 sm:p-4 border-2 rounded-xl <?= $wrapClass ?> flex items-start">
                                   <?= $badgeHtml ?>
                                   <span class="font-bold text-slate-700 mr-2 shrink-0 pt-0.5"><?= $k ?>.</span>
                                   <div class="text-sm sm:text-base break-words whitespace-pre-wrap leading-relaxed w-full min-w-0"><?= render_text($v ?? '') ?></div>
                               </div>
                           <?php endforeach; ?>
                       </div>
                   <?php elseif($d['q_type'] == 'tf'): $u_ans = json_decode($d['user_answer'], true) ?: []; ?>
                       <div class="w-full rounded-lg border mt-2 overflow-hidden">
                           <table class="w-full text-sm text-left table-fixed">
                               <thead class="bg-slate-50 border-b">
                                   <tr>
                                       <th class="p-2 text-center w-[10%]">Ý</th>
                                       <th class="p-2 w-[50%] sm:w-[60%]">Nội dung</th>
                                       <th class="p-1 sm:p-2 text-center w-[20%] sm:w-[15%] text-[10px] sm:text-sm">Bạn chọn</th>
                                       <th class="p-1 sm:p-2 text-center w-[20%] sm:w-[15%] text-[10px] sm:text-sm">Đ.Án</th>
                                   </tr>
                               </thead>
                               <tbody class="divide-y divide-slate-100 bg-white">
                                   <?php foreach(['a'=>['text'=>$d['part_a'], 'correct'=>$d['is_a_true']], 'b'=>['text'=>$d['part_b'], 'correct'=>$d['is_b_true']], 'c'=>['text'=>$d['part_c'], 'correct'=>$d['is_c_true']], 'd'=>['text'=>$d['part_d'], 'correct'=>$d['is_d_true']]] as $k => $v):
                                       $u_chose = (isset($u_ans[$k]) && $u_ans[$k] !== -1) ? $u_ans[$k] : null; 
                                       $is_match = ($u_chose !== null && $u_chose == $v['correct']); 
                                       $rowBg = $is_match ? '' : 'bg-rose-50/50';
                                   ?>
                                   <tr class="<?= $rowBg ?>">
                                       <td class="p-2 text-center font-bold uppercase w-[10%] align-middle"><?= $k ?></td>
                                       <td class="p-2 break-words align-middle leading-relaxed w-[50%] sm:w-[60%] whitespace-pre-wrap text-left"><?= render_text($v['text'] ?? '') ?></td>
                                       <td class="p-1 sm:p-2 text-center font-bold text-[10px] sm:text-sm w-[20%] sm:w-[15%] align-middle <?= $u_chose === null ? 'text-slate-400' : ($u_chose == 1 ? 'text-emerald-600' : 'text-rose-600') ?>">
                                           <?= $u_chose === null ? 'Bỏ' : ($u_chose == 1 ? 'ĐÚNG' : 'SAI') ?>
                                       </td>
                                       <td class="p-1 sm:p-2 text-center font-bold text-blue-600 text-[10px] sm:text-sm w-[20%] sm:w-[15%] align-middle"><?= $v['correct'] == 1 ? 'ĐÚNG' : 'SAI' ?></td>
                                   </tr>
                                   <?php endforeach; ?>
                               </tbody>
                           </table>
                       </div>
                   <?php endif; ?>
               </div>
           <?php endforeach; ?>
       </div>
       <div class="text-center mt-10"><a href="index.php" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-primary text-white font-bold py-3 px-8 rounded-full transition-colors shadow-lg"><i class="fa-solid fa-house"></i> Về trang chính</a></div>
   </div>

<?php 
elseif (is_logged_in() && is_admin() && $action == 'admin'): 
   $total_users = $pdo->query("SELECT COUNT(*) FROM users WHERE role='user'")->fetchColumn();
   $total_exams = $pdo->query("SELECT COUNT(*) FROM exams")->fetchColumn();
   $total_takes = $pdo->query("SELECT COUNT(*) FROM results")->fetchColumn();
   $avg_score = $pdo->query("SELECT AVG(score) FROM results")->fetchColumn();
   $history = $pdo->query("SELECT r.*, u.username, u.fullname, e.title as exam_title FROM results r JOIN users u ON r.user_id = u.id JOIN exams e ON r.exam_id = e.id ORDER BY r.created_at DESC LIMIT 50")->fetchAll();
   $all_exams = $pdo->query("SELECT * FROM exams ORDER BY id DESC")->fetchAll();
   $all_users = $pdo->query("SELECT * FROM users WHERE role='user' ORDER BY id DESC")->fetchAll();
?>
   <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 w-full">
       <div class="bg-slate-800 rounded-3xl p-8 mb-8 text-white shadow-xl relative overflow-hidden">
           <div class="relative z-10 flex flex-col sm:flex-row justify-between items-center gap-6">
               <div>
                   <h1 class="text-3xl font-black mb-2 text-indigo-300">Trung Tâm Quản Trị Hệ Thống</h1>
                   <p class="text-slate-400 font-medium">Xin chào Admin! Quản lý toàn bộ đề thi, học viên và theo dõi chi tiết điểm số tại khu vực này.</p>
               </div>
               <div class="flex gap-3 shrink-0 flex-wrap sm:flex-nowrap">
                   <a href="?action=admin_settings" class="bg-slate-700 hover:bg-slate-600 text-white px-5 py-3 rounded-xl shadow-lg font-bold transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-gear text-xl"></i> Cài Đặt HT</a>
                   <a href="?action=admin_create_exam" class="bg-primary hover:bg-indigo-500 text-white px-6 py-3 rounded-xl shadow-lg shadow-primary/30 font-bold transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-file-circle-plus text-xl"></i> Soạn Đề Mới Ngay</a>
               </div>
           </div>
           <i class="fa-solid fa-shield-halved absolute -right-10 -bottom-10 text-[180px] opacity-10"></i>
       </div>

       <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
           <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden"><div class="absolute right-[-10%] top-[-10%] text-blue-500/10 text-7xl"><i class="fa-solid fa-users"></i></div><div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tổng Học Sinh</div><div class="text-3xl font-black text-blue-600"><?= $total_users ?></div></div>
           <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden"><div class="absolute right-[-10%] top-[-10%] text-emerald-500/10 text-7xl"><i class="fa-solid fa-file-pen"></i></div><div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tổng Lượt Thi</div><div class="text-3xl font-black text-emerald-600"><?= $total_takes ?></div></div>
           <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden"><div class="absolute right-[-10%] top-[-10%] text-purple-500/10 text-7xl"><i class="fa-solid fa-layer-group"></i></div><div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Số Đề Thi</div><div class="text-3xl font-black text-purple-600"><?= $total_exams ?></div></div>
           <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden"><div class="absolute right-[-10%] top-[-10%] text-amber-500/10 text-7xl"><i class="fa-solid fa-chart-line"></i></div><div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Điểm Trung Bình</div><div class="text-3xl font-black text-amber-500"><?= number_format((float)$avg_score, 2) ?></div></div>
       </div>
       
       <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
           <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
               <h3 class="font-bold text-slate-800 text-lg"><i class="fa-solid fa-rectangle-list text-primary mr-2"></i> Quản Lý Đề Thi</h3>
           </div>
           <div class="overflow-x-auto w-full">
               <table class="min-w-full text-left border-collapse">
                   <thead class="bg-slate-50 border-b text-xs uppercase font-bold text-slate-500"><tr><th class="px-6 py-4">Tên Đề</th><th class="px-6 py-4 text-center">Mã</th><th class="px-6 py-4 text-center">Thời gian</th><th class="px-6 py-4 text-center">Trạng thái</th><th class="px-6 py-4 text-right">Hành động</th></tr></thead>
                   <tbody class="divide-y divide-slate-100 text-sm">
                       <?php foreach($all_exams as $ex): ?>
                       <tr class="hover:bg-slate-50 transition-colors">
                           <td class="px-6 py-4 font-bold text-slate-800"><?= htmlspecialchars($ex['title']) ?></td>
                           <td class="px-6 py-4 text-center"><span class="bg-slate-100 px-2 py-1 rounded text-xs font-bold"><?= htmlspecialchars($ex['code']) ?></span></td>
                           <td class="px-6 py-4 text-center"><?= $ex['duration'] ?>p</td>
                           <td class="px-6 py-4 text-center">
                               <a href="?action=admin_toggle_exam&id=<?= $ex['id'] ?>" class="text-xs font-bold px-2 py-1 rounded <?= $ex['status']=='active' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' ?>"><?= $ex['status']=='active' ? 'Đang Mở' : 'Đã Đóng' ?></a>
                           </td>
                           <td class="px-6 py-4 text-right space-x-2">
                               <a href="?action=admin_exam_form&id=<?= $ex['id'] ?>" class="inline-block bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1.5 rounded font-bold"><i class="fa-solid fa-pen"></i> Sửa</a>
                               <a href="?action=admin_delete_exam&id=<?= $ex['id'] ?>" onclick="return confirm('Chắc chắn xóa? Toàn bộ kết quả của học sinh cũng sẽ mất!')" class="inline-block bg-rose-100 text-rose-700 hover:bg-rose-200 px-3 py-1.5 rounded font-bold"><i class="fa-solid fa-trash"></i></a>
                           </td>
                       </tr>
                       <?php endforeach; ?>
                   </tbody>
               </table>
           </div>
       </div>

       <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
           <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
               <h3 class="font-bold text-slate-800 text-lg"><i class="fa-solid fa-clock-rotate-left text-primary mr-2"></i> Lịch Sử Nộp Bài Gần Đây</h3>
           </div>
           <div class="overflow-x-auto w-full">
               <table class="min-w-full text-left border-collapse">
                   <thead class="bg-slate-50 border-b text-xs uppercase font-bold text-slate-500"><tr><th class="px-6 py-4">Tài khoản</th><th class="px-6 py-4">Đề thi</th><th class="px-6 py-4 text-center">Điểm</th><th class="px-6 py-4 text-center">Nộp lúc</th><th class="px-6 py-4"></th></tr></thead>
                   <tbody class="divide-y divide-slate-100 text-sm">
                       <?php foreach($history as $h): ?>
                       <tr class="hover:bg-slate-50 transition-colors">
                           <td class="px-6 py-4"><div class="font-bold text-slate-800">@<?= htmlspecialchars($h['username']) ?></div><div class="text-xs text-slate-500 mt-0.5"><?= htmlspecialchars($h['fullname']) ?></div></td>
                           <td class="px-6 py-4 font-medium text-slate-700"><span class="line-clamp-2"><?= htmlspecialchars($h['exam_title']) ?></span></td>
                           <td class="px-6 py-4 text-center"><span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 font-bold <?= $h['score'] >= 5 ? 'text-emerald-600' : 'text-rose-600' ?>"><?= number_format($h['score'], 1) ?></span></td>
                           <td class="px-6 py-4 text-center text-slate-500"><?= date('d/m/Y H:i', strtotime($h['created_at'])) ?></td>
                           <td class="px-6 py-4 text-right"><a href="?action=result&id=<?= $h['id'] ?>" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-primary hover:bg-primary hover:text-white transition shadow-sm"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></td>
                       </tr>
                       <?php endforeach; ?>
                       <?php if(empty($history)): ?><tr><td colspan='5' class='text-center py-10 text-slate-400'>Chưa có lượt làm bài nào.</td></tr><?php endif; ?>
                   </tbody>
               </table>
           </div>
       </div>

       <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
           <div class="px-6 py-5 border-b border-slate-100"><h3 class="font-bold text-slate-800 text-lg"><i class="fa-solid fa-users text-emerald-600 mr-2"></i> Danh Sách Học Sinh</h3></div>
           <div class="overflow-x-auto w-full max-h-96">
               <table class="min-w-full text-left text-sm">
                   <thead class="bg-white border-b text-xs uppercase font-bold text-slate-500 sticky top-0 z-10 shadow-sm"><tr><th class="px-6 py-4">ID</th><th class="px-6 py-4">Tài khoản</th><th class="px-6 py-4">Họ và Tên</th><th class="px-6 py-4 text-right">Ngày đăng ký</th></tr></thead>
                   <tbody class="divide-y divide-slate-100">
                       <?php foreach($all_users as $u): ?>
                       <tr class="hover:bg-slate-50">
                           <td class="px-6 py-4 font-mono text-slate-400">#<?= $u['id'] ?></td>
                           <td class="px-6 py-4 font-bold text-primary">@<?= htmlspecialchars($u['username']) ?></td>
                           <td class="px-6 py-4 font-bold text-slate-700"><?= htmlspecialchars($u['fullname']) ?></td>
                           <td class="px-6 py-4 text-right text-slate-500"><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                       </tr>
                       <?php endforeach; ?>
                   </tbody>
               </table>
           </div>
       </div>
   </div>

<?php 
elseif (is_logged_in() && is_admin() && $action == 'admin_settings'): 
?>
   <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 w-full overflow-hidden">
       <div class="flex items-center gap-3 mb-6">
           <a href="?action=admin" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-3 py-2 rounded-lg font-bold transition"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
           <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">Cài Đặt Hệ Thống</h1>
       </div>

       <form method="POST" action="?action=admin_save_settings" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
           <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

           <h2 class="text-lg font-bold mb-5 flex items-center gap-2 border-b border-slate-100 pb-3 text-primary"><i class="fa-solid fa-image"></i> Cấu hình Logo & Favicon</h2>
           
           <div class="space-y-6">
               <div>
                   <label class="block font-bold text-sm text-slate-700 mb-3">Loại hiển thị Logo <span class="text-rose-500">*</span></label>
                   <div class="flex gap-4">
                       <label class="flex items-center gap-2 bg-slate-50 border border-slate-200 px-4 py-2.5 rounded-xl cursor-pointer hover:border-primary transition-all has-[:checked]:border-primary has-[:checked]:bg-indigo-50">
                           <input type="radio" name="logo_type" value="icon" <?= ($site_settings['logo_type'] ?? 'icon') == 'icon' ? 'checked' : '' ?> class="text-primary focus:ring-primary w-4 h-4 cursor-pointer" onchange="toggleLogoSettings()">
                           <span class="font-bold text-slate-700 text-sm">Dùng Icon FontAwesome</span>
                       </label>
                       <label class="flex items-center gap-2 bg-slate-50 border border-slate-200 px-4 py-2.5 rounded-xl cursor-pointer hover:border-primary transition-all has-[:checked]:border-primary has-[:checked]:bg-indigo-50">
                           <input type="radio" name="logo_type" value="image" <?= ($site_settings['logo_type'] ?? 'icon') == 'image' ? 'checked' : '' ?> class="text-primary focus:ring-primary w-4 h-4 cursor-pointer" onchange="toggleLogoSettings()">
                           <span class="font-bold text-slate-700 text-sm">Dùng Hình Ảnh</span>
                       </label>
                   </div>
               </div>

               <div id="setting_logo_icon" class="<?= ($site_settings['logo_type'] ?? 'icon') == 'icon' ? 'block' : 'hidden' ?> bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                   <label class="block font-bold text-sm text-slate-700 mb-1.5">Class Icon FontAwesome (v6.4.0)</label>
                   <p class="text-xs text-slate-500 mb-2">Truy cập fontawesome.com để lấy class. VD: <code class="bg-slate-200 px-1 rounded">fa-solid fa-graduation-cap</code></p>
                   <div class="flex gap-3">
                       <input type="text" id="logo_icon_input" name="logo_icon" value="<?= htmlspecialchars($site_settings['logo_icon'] ?? '') ?>" class="block w-full border border-slate-300 px-4 py-2.5 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm transition-all" oninput="document.getElementById('icon_preview').className = this.value + ' text-3xl text-primary'">
                       <div class="w-12 h-11 shrink-0 bg-white border border-slate-200 rounded-xl flex items-center justify-center">
                           <i id="icon_preview" class="<?= htmlspecialchars($site_settings['logo_icon'] ?? 'fa-solid fa-laptop-code') ?> text-2xl text-primary"></i>
                       </div>
                   </div>
               </div>

               <div id="setting_logo_image" class="<?= ($site_settings['logo_type'] ?? 'icon') == 'image' ? 'block' : 'hidden' ?> bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                   <label class="block font-bold text-sm text-slate-700 mb-1.5">Hình ảnh Logo (URL hoặc Upload)</label>
                   <div class="flex flex-col sm:flex-row gap-3">
                       <div class="w-16 h-16 shrink-0 bg-white border border-slate-200 rounded-xl flex items-center justify-center overflow-hidden">
                           <img id="logo_img_preview" src="<?= htmlspecialchars($site_settings['logo_image'] ?? '') ?>" class="max-w-full max-h-full object-contain <?= empty($site_settings['logo_image']) ? 'hidden' : '' ?>">
                           <i id="logo_img_placeholder" class="fa-regular fa-image text-2xl text-slate-300 <?= !empty($site_settings['logo_image']) ? 'hidden' : '' ?>"></i>
                       </div>
                       <div class="flex-grow space-y-2">
                           <div class="flex gap-2">
                               <input type="text" id="logo_image_input" name="logo_image" value="<?= htmlspecialchars($site_settings['logo_image'] ?? '') ?>" class="block w-full border border-slate-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm transition-all" placeholder="https://..." oninput="updatePreview('logo_image_input', 'logo_img_preview', 'logo_img_placeholder')">
                               <button type="button" onclick="document.getElementById('upload_logo').click()" class="shrink-0 bg-white border border-slate-300 hover:bg-slate-50 px-3 py-2 rounded-lg text-sm font-bold text-slate-700 transition flex items-center gap-2"><i class="fa-solid fa-cloud-arrow-up"></i> Upload</button>
                               <input type="file" id="upload_logo" accept="image/*" class="hidden" onchange="uploadSettingFile(this, 'logo_image_input', 'logo_img_preview', 'logo_img_placeholder')">
                           </div>
                           <p class="text-xs text-slate-500">Nên dùng ảnh PNG vuông có nền trong suốt.</p>
                       </div>
                   </div>
               </div>

               <div class="w-full h-px bg-slate-100 my-4"></div>

               <div>
                   <label class="block font-bold text-sm text-slate-700 mb-1.5">Hình ảnh Favicon (Icon trên Tab Trình Duyệt)</label>
                   <div class="flex flex-col sm:flex-row gap-3">
                       <div class="w-12 h-12 shrink-0 bg-white border border-slate-200 rounded-xl flex items-center justify-center overflow-hidden">
                           <img id="fav_img_preview" src="<?= htmlspecialchars($site_settings['favicon'] ?? '') ?>" class="max-w-full max-h-full object-contain <?= empty($site_settings['favicon']) ? 'hidden' : '' ?>">
                           <i id="fav_img_placeholder" class="fa-solid fa-globe text-xl text-slate-300 <?= !empty($site_settings['favicon']) ? 'hidden' : '' ?>"></i>
                       </div>
                       <div class="flex-grow space-y-2">
                           <div class="flex gap-2">
                               <input type="text" id="favicon_input" name="favicon" value="<?= htmlspecialchars($site_settings['favicon'] ?? '') ?>" class="block w-full border border-slate-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm transition-all" placeholder="https://..." oninput="updatePreview('favicon_input', 'fav_img_preview', 'fav_img_placeholder')">
                               <button type="button" onclick="document.getElementById('upload_fav').click()" class="shrink-0 bg-white border border-slate-300 hover:bg-slate-50 px-3 py-2 rounded-lg text-sm font-bold text-slate-700 transition flex items-center gap-2"><i class="fa-solid fa-cloud-arrow-up"></i> Upload</button>
                               <input type="file" id="upload_fav" accept=".ico,.png,.webp,.jpg" class="hidden" onchange="uploadSettingFile(this, 'favicon_input', 'fav_img_preview', 'fav_img_placeholder')">
                           </div>
                           <p class="text-xs text-slate-500">Hỗ trợ định dạng .ico hoặc .png (Kích thước khuyên dùng: 32x32 hoặc 64x64).</p>
                       </div>
                   </div>
               </div>

           </div>

           <div class="mt-8 pt-5 border-t border-slate-100 text-right">
               <button type="submit" class="bg-primary hover:bg-secondary text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-primary/30 transition-all text-sm flex items-center justify-center gap-2 w-full sm:w-auto ml-auto">
                   <i class="fa-solid fa-floppy-disk"></i> LƯU CÀI ĐẶT
               </button>
           </div>
       </form>
   </div>

   <script>
       function toggleLogoSettings() {
           const isIcon = document.querySelector('input[name="logo_type"][value="icon"]').checked;
           document.getElementById('setting_logo_icon').style.display = isIcon ? 'block' : 'none';
           document.getElementById('setting_logo_image').style.display = isIcon ? 'none' : 'block';
       }

       function updatePreview(inputId, imgId, placeholderId) {
           const url = document.getElementById(inputId).value;
           const img = document.getElementById(imgId);
           const placeholder = document.getElementById(placeholderId);
           
           if(url) {
               img.src = url;
               img.classList.remove('hidden');
               placeholder.classList.add('hidden');
           } else {
               img.classList.add('hidden');
               placeholder.classList.remove('hidden');
           }
       }

       function uploadSettingFile(input, targetInputId, previewImgId, placeholderId) {
           if(!input.files || input.files.length === 0) return;
           const file = input.files[0];
           if(file.size > 5 * 1024 * 1024) { alert("File vượt quá 5MB!"); return; }
           
           const targetInput = document.getElementById(targetInputId);
           const originalText = targetInput.value;
           targetInput.value = "Đang tải lên...";
           targetInput.disabled = true;

           const formData = new FormData(); formData.append('file', file);
           fetch('index.php?action=ajax_upload_image', { method: 'POST', body: formData })
           .then(response => response.json())
           .then(data => {
               targetInput.disabled = false;
               if(data.error) { 
                   targetInput.value = originalText;
                   alert("Lỗi: " + data.error); 
               } else if(data.url) {
                   targetInput.value = data.url;
                   updatePreview(targetInputId, previewImgId, placeholderId);
               }
           })
           .catch(error => { 
               targetInput.disabled = false;
               targetInput.value = originalText;
               alert("Lỗi kết nối máy chủ!"); 
           });
       }
   </script>

<?php 
elseif (is_logged_in() && is_admin() && in_array($action, ['admin_create_exam', 'admin_exam_form'])): 
    $edit_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $is_edit = $edit_id > 0;
    $ex_data = ['title'=>'', 'code'=>'', 'duration'=>50, 'description'=>''];
    $q_mcq = []; $q_tf = [];

    if ($is_edit) {
        $ex_data = $pdo->query("SELECT * FROM exams WHERE id = $edit_id")->fetch();
        if(!$ex_data) die("Không tìm thấy đề thi");
        
        $stmt_mcq = $pdo->query("SELECT q.q_index, q.content, q.layout, q.left_content, q.right_content, a.opt_a, a.opt_b, a.opt_c, a.opt_d, a.correct_opt FROM questions q JOIN answers_mcq a ON q.id = a.question_id WHERE q.exam_id = $edit_id AND q.q_type = 'mcq'");
        while($row = $stmt_mcq->fetch()) { $q_mcq[$row['q_index']] = $row; }
        
        $stmt_tf = $pdo->query("SELECT q.q_index, q.content, q.layout, q.left_content, q.right_content, a.part_a, a.is_a_true, a.part_b, a.is_b_true, a.part_c, a.is_c_true, a.part_d, a.is_d_true FROM questions q JOIN answers_tf a ON q.id = a.question_id WHERE q.exam_id = $edit_id AND q.q_type = 'tf'");
        while($row = $stmt_tf->fetch()) { $q_tf[$row['q_index']] = $row; }
    }
?>
   <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 w-full overflow-hidden">
       <div class="flex items-center gap-3 mb-6">
           <a href="?action=admin" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-3 py-2 rounded-lg font-bold"><i class="fa-solid fa-arrow-left"></i></a>
           <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">
               <?= $is_edit ? 'Sửa Đề Thi <span class="text-primary">#'.$edit_id.'</span>' : 'Soạn Đề Thi Mới' ?>
           </h1>
       </div>
       
       <div class="bg-indigo-50 text-indigo-800 p-4 sm:p-5 rounded-2xl border border-indigo-100 mb-8 text-sm leading-relaxed shadow-sm break-words">
           <p class="mb-2"><i class="fa-solid fa-circle-info mr-1.5"></i> <b>Hướng dẫn quan trọng:</b></p>
           <ul class="list-disc pl-8 space-y-1 text-indigo-700/80 mb-2 font-medium">
               <li>Hỗ trợ <b>chèn Bảng (Table)</b> và <b>Đoạn Code Lập Trình</b> trực tiếp vào câu hỏi và đáp án hiển thị cực đẹp.</li>
               <li>Sử dụng chức năng <b>Nhập Nhanh</b> (Chia 2 ô riêng biệt cho Trắc Nghiệm và Đúng/Sai) để điền đề trong 1 click.</li>
               <li>Bạn có thể <b>nhấn phím Tab</b> để thụt lề khi tự gõ code trong các ô nội dung.</li>
           </ul>
       </div>
       
       <form method="POST" action="?action=admin_submit_exam" class="space-y-8 w-full" id="createExamForm">
           <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
           <?php if($is_edit): ?><input type="hidden" name="edit_exam_id" value="<?= $edit_id ?>"><?php endif; ?>
           
           <div class="bg-white p-5 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
               <h2 class="text-lg font-bold mb-5 flex items-center gap-2 border-b pb-3"><i class="fa-solid fa-sliders text-slate-400"></i> Cài đặt chung</h2>
               <div class="flex flex-col sm:grid sm:grid-cols-2 gap-5 w-full">
                   <div class="w-full">
                       <label class="block font-bold text-sm text-slate-700 mb-1.5">Tên đề thi <span class="text-rose-500">*</span></label>
                       <input type="text" name="title" value="<?= htmlspecialchars($ex_data['title']) ?>" required class="block w-full border border-slate-300 px-4 py-2.5 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all box-border" placeholder="VD: Đề thi thử THPT Quốc Gia">
                   </div>
                   <div class="w-full">
                       <label class="block font-bold text-sm text-slate-700 mb-1.5">Mã đề <span class="text-rose-500">*</span></label>
                       <input type="text" name="code" value="<?= htmlspecialchars($ex_data['code']) ?>" required class="block w-full border border-slate-300 px-4 py-2.5 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all box-border" placeholder="VD: THPT-001">
                   </div>
                   <div class="w-full">
                       <label class="block font-bold text-sm text-slate-700 mb-1.5">Thời gian làm bài (Phút) <span class="text-rose-500">*</span></label>
                       <input type="number" name="duration" value="<?= $ex_data['duration'] ?>" required class="block w-full border border-slate-300 px-4 py-2.5 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all box-border">
                   </div>
                   <div class="w-full">
                       <label class="block font-bold text-sm text-slate-700 mb-1.5">Mô tả ngắn</label>
                       <input type="text" name="description" value="<?= htmlspecialchars($ex_data['description'] ?? '') ?>" class="block w-full border border-slate-300 px-4 py-2.5 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all box-border" placeholder="Ghi chú (không bắt buộc)">
                   </div>
               </div>
           </div>

           <div class="bg-white p-4 sm:p-8 rounded-2xl shadow-sm border border-slate-200 w-full overflow-hidden">
               <div class="flex items-center gap-2 mb-6 border-b border-primary/20 pb-3">
                   <div class="bg-primary text-white w-8 h-8 rounded-lg flex items-center justify-center font-bold shrink-0">I</div>
                   <h2 class="text-lg sm:text-xl font-bold text-primary">24 Câu Trắc Nghiệm</h2>
               </div>

               <div class="bg-indigo-50/50 p-4 sm:p-6 rounded-2xl shadow-sm border border-indigo-200 mb-8 relative overflow-hidden">
                   <div class="absolute top-0 left-0 w-2 h-full bg-primary"></div>
                   <h3 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bolt text-amber-500"></i> Nhập Nhanh Trắc Nghiệm (Dán liên tiếp)</h3>
                   <p class="text-xs text-slate-600 mb-3">Hệ thống nhận diện từng câu hỏi, cắt bỏ các mã số (như 1.9.1...), bóc tách A, B, C, D và tự động tìm đáp án đúng. <br><span class="font-bold text-indigo-700">MẸO TẠO KHUNG CODE:</span> Bọc đoạn mã bằng 3 dấu gạch chéo ngược (VD: ```html hoặc ```python) hệ thống sẽ tự sinh khung Code nền đen chuyên nghiệp.</p>
                   <textarea id="fastInputMCQ" class="w-full border border-indigo-300 rounded-lg p-4 text-sm bg-white focus:ring-2 focus:ring-primary/30 outline-none transition-all custom-scrollbar whitespace-pre-wrap" rows="5" placeholder="Dán nội dung các câu trắc nghiệm (A, B, C, D) vào đây... 
Hệ thống xử lý được mọi định dạng số câu (Câu 1., 1.9_1_3_1...)."></textarea>
                   <button type="button" onclick="parseFastInput('mcq')" class="mt-3 bg-primary hover:bg-secondary text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-all flex items-center gap-2 text-sm active:scale-95">
                       <i class="fa-solid fa-wand-magic-sparkles"></i> Phân Tích & Điền Tiếp Nối
                   </button>
               </div>
               
               <div class="space-y-8 w-full">
                   <?php for($i=1; $i<=24; $i++): 
                       $q_data = $q_mcq[$i] ?? null;
                       $layout = $q_data['layout'] ?? 'normal';
                       $has_py = strpos($layout, 'python') !== false;
                       $has_cpp = strpos($layout, 'cpp') !== false;
                   ?>
                   <div class="p-4 sm:p-6 bg-slate-50 border border-slate-200 rounded-2xl relative w-full box-border">
                       <div class="absolute -top-3 -left-3 bg-slate-800 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shadow-md border-2 border-white z-10"><?= $i ?></div>
                       
                       <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-3 gap-3 pl-4 sm:pl-0 w-full">
                           <span class="font-bold text-slate-800 flex items-center gap-2 shrink-0">Nội dung câu hỏi: 
                               <button type="button" onclick="openMediaModal('mcq_<?= $i ?>_content_input')" class="text-xs bg-indigo-100 text-primary hover:bg-indigo-200 px-2 py-1 rounded font-bold transition whitespace-nowrap"><i class="fa-regular fa-image"></i> Ảnh</button>
                               <button type="button" onclick="openTableModal('mcq_<?= $i ?>_content_input')" class="text-xs bg-blue-100 text-blue-700 hover:bg-blue-200 px-2 py-1 rounded font-bold transition whitespace-nowrap"><i class="fa-solid fa-table"></i> Bảng</button>
                               <button type="button" onclick="openCodeModal('mcq_<?= $i ?>_content_input')" class="text-xs bg-slate-800 text-white hover:bg-slate-700 px-2 py-1 rounded font-bold transition whitespace-nowrap"><i class="fa-solid fa-code"></i> Code</button>
                           </span>
                           
                           <div class="flex items-center gap-4 bg-white border border-slate-300 px-4 py-2 rounded-xl text-sm font-bold shadow-sm w-full sm:w-auto box-border">
                               <span class="text-slate-500 mr-1"><i class="fa-solid fa-columns"></i> Cột Code:</span>
                               <label class="flex items-center cursor-pointer hover:text-indigo-600 transition">
                                   <input type="checkbox" name="mcq_<?= $i ?>_show_py" value="1" onchange="toggleCodeCol('mcq_<?= $i ?>', 'py', this.checked)" <?= $has_py ? 'checked' : '' ?> class="w-4 h-4 text-indigo-600 mr-2 rounded shrink-0 cursor-pointer"> Python
                               </label>
                               <div class="w-px h-4 bg-slate-300"></div>
                               <label class="flex items-center cursor-pointer hover:text-amber-600 transition">
                                   <input type="checkbox" name="mcq_<?= $i ?>_show_cpp" value="1" onchange="toggleCodeCol('mcq_<?= $i ?>', 'cpp', this.checked)" <?= $has_cpp ? 'checked' : '' ?> class="w-4 h-4 text-amber-600 mr-2 rounded shrink-0 cursor-pointer"> C++
                               </label>
                           </div>
                       </div>
                       
                       <div class="mb-4 w-full box-border">
                           <textarea id="mcq_<?= $i ?>_content_input" name="mcq_<?= $i ?>_content" required class="block w-full border border-slate-300 p-3 sm:p-4 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all box-border" rows="3" placeholder="Nhập câu hỏi..."><?= htmlspecialchars($q_data['content'] ?? '') ?></textarea>
                       </div>
                       
                       <div id="code_cols_mcq_<?= $i ?>" class="<?= ($has_py || $has_cpp) ? 'grid' : 'hidden' ?> <?= ($has_py && $has_cpp) ? 'grid-cols-1 xl:grid-cols-2' : 'grid-cols-1' ?> gap-4 mb-4 w-full box-border">
                           <div id="col_py_mcq_<?= $i ?>" class="relative w-full <?= $has_py ? 'block' : 'hidden' ?>">
                               <div class="absolute top-2 left-3 text-xs font-black text-indigo-600 uppercase"><i class="fa-brands fa-python"></i> Python</div>
                               <div class="absolute top-2 right-2 flex gap-1">
                                   <button type="button" onclick="openMediaModal('mcq_<?= $i ?>_left_input')" class="text-xs bg-white text-slate-500 border border-indigo-200 px-2 py-1 rounded shadow-sm hover:text-primary"><i class="fa-regular fa-image"></i></button>
                                   <button type="button" onclick="openTableModal('mcq_<?= $i ?>_left_input')" class="text-xs bg-white text-slate-500 border border-indigo-200 px-2 py-1 rounded shadow-sm hover:text-blue-600"><i class="fa-solid fa-table"></i></button>
                                   <button type="button" onclick="openCodeModal('mcq_<?= $i ?>_left_input')" class="text-xs bg-white text-slate-500 border border-indigo-200 px-2 py-1 rounded shadow-sm hover:text-slate-800"><i class="fa-solid fa-code"></i></button>
                               </div>
                               <textarea id="mcq_<?= $i ?>_left_input" name="mcq_<?= $i ?>_left" class="block w-full border border-indigo-200 bg-indigo-50/50 p-3 pt-10 rounded-xl text-sm focus:border-indigo-400 outline-none box-border font-mono whitespace-pre-wrap" rows="4" placeholder="Nhập code Python..."><?= htmlspecialchars($q_data['left_content'] ?? '') ?></textarea>
                           </div>
                           <div id="col_cpp_mcq_<?= $i ?>" class="relative w-full <?= $has_cpp ? 'block' : 'hidden' ?>">
                               <div class="absolute top-2 left-3 text-xs font-black text-amber-600 uppercase"><i class="fa-solid fa-code"></i> C++</div>
                               <div class="absolute top-2 right-2 flex gap-1">
                                   <button type="button" onclick="openMediaModal('mcq_<?= $i ?>_right_input')" class="text-xs bg-white text-slate-500 border border-amber-200 px-2 py-1 rounded shadow-sm hover:text-primary"><i class="fa-regular fa-image"></i></button>
                                   <button type="button" onclick="openTableModal('mcq_<?= $i ?>_right_input')" class="text-xs bg-white text-slate-500 border border-amber-200 px-2 py-1 rounded shadow-sm hover:text-blue-600"><i class="fa-solid fa-table"></i></button>
                                   <button type="button" onclick="openCodeModal('mcq_<?= $i ?>_right_input')" class="text-xs bg-white text-slate-500 border border-amber-200 px-2 py-1 rounded shadow-sm hover:text-slate-800"><i class="fa-solid fa-code"></i></button>
                               </div>
                               <textarea id="mcq_<?= $i ?>_right_input" name="mcq_<?= $i ?>_right" class="block w-full border border-amber-200 bg-amber-50/50 p-3 pt-10 rounded-xl text-sm focus:border-amber-400 outline-none box-border font-mono whitespace-pre-wrap" rows="4" placeholder="Nhập code C++..."><?= htmlspecialchars($q_data['right_content'] ?? '') ?></textarea>
                           </div>
                       </div>

                       <div class="mt-4 pt-4 border-t border-slate-200 w-full">
                           <div class="text-sm font-bold text-slate-500 mb-3 uppercase tracking-wider">Đáp án:</div>
                           <div class="flex flex-col xl:grid xl:grid-cols-2 gap-3 w-full">
                               <?php foreach(['a','b','c','d'] as $opt): 
                                   $is_checked = ($q_data && strtolower($q_data['correct_opt']) == $opt);
                               ?>
                               <div class="flex items-stretch bg-white border border-slate-300 rounded-xl p-1 gap-1 cursor-pointer hover:border-primary transition-all has-[:checked]:border-emerald-500 has-[:checked]:ring-1 has-[:checked]:ring-emerald-500 has-[:checked]:bg-emerald-50/30 group w-full box-border">
                                   <label class="flex flex-grow items-start cursor-pointer px-2 py-2 min-w-0">
                                       <input type="radio" name="mcq_<?= $i ?>_correct" value="<?= strtoupper($opt) ?>" <?= $is_checked ? 'checked' : '' ?> class="w-5 h-5 text-emerald-500 focus:ring-emerald-500 border-slate-400 mt-0.5 shrink-0 cursor-pointer">
                                       <span class="font-black text-slate-700 w-7 text-center shrink-0 ml-1"><?= strtoupper($opt) ?>.</span>
                                       <textarea id="mcq_<?= $i ?>_<?= $opt ?>_input" name="mcq_<?= $i ?>_<?= $opt ?>" required class="flex-grow border-none bg-transparent focus:ring-0 px-1 text-sm outline-none min-w-0 resize-y custom-scrollbar whitespace-pre-wrap" rows="2" placeholder="Nội dung..."><?= htmlspecialchars($q_data['opt_'.$opt] ?? '') ?></textarea>
                                   </label>
                                   <div class="flex flex-col gap-1 shrink-0 px-1 py-1 bg-slate-50 border-l border-slate-100 rounded-r-lg justify-center">
                                       <button type="button" onclick="openMediaModal('mcq_<?= $i ?>_<?= $opt ?>_input')" class="p-1.5 text-slate-400 hover:text-primary transition" title="Chèn Ảnh"><i class="fa-regular fa-image"></i></button>
                                       <button type="button" onclick="openTableModal('mcq_<?= $i ?>_<?= $opt ?>_input')" class="p-1.5 text-slate-400 hover:text-blue-600 transition" title="Chèn Bảng"><i class="fa-solid fa-table"></i></button>
                                       <button type="button" onclick="openCodeModal('mcq_<?= $i ?>_<?= $opt ?>_input')" class="p-1.5 text-slate-400 hover:text-slate-800 transition" title="Chèn Đoạn Code"><i class="fa-solid fa-code"></i></button>
                                   </div>
                               </div>
                               <?php endforeach; ?>
                           </div>
                       </div>
                   </div>
                   <?php endfor; ?>
               </div>
           </div>

           <div class="bg-white p-4 sm:p-8 rounded-2xl shadow-sm border border-slate-200 w-full overflow-hidden">
               <div class="flex items-center gap-2 mb-6 border-b border-purple-200 pb-3">
                   <div class="bg-purple-600 text-white w-8 h-8 rounded-lg flex items-center justify-center font-bold shrink-0">II</div>
                   <h2 class="text-lg sm:text-xl font-bold text-purple-700">4 Câu Đúng/Sai</h2>
               </div>
               
               <div class="bg-purple-50/50 p-4 sm:p-6 rounded-2xl shadow-sm border border-purple-200 mb-8 relative overflow-hidden">
                   <div class="absolute top-0 left-0 w-2 h-full bg-purple-600"></div>
                   <h3 class="font-bold text-purple-700 mb-2 flex items-center gap-2"><i class="fa-solid fa-bolt text-amber-500"></i> Nhập Nhanh Đúng/Sai (Dán liên tiếp)</h3>
                   <p class="text-xs text-slate-600 mb-3">Tự động phân tách 4 ý a,b,c,d. Tự động tick Đúng/Sai nếu trong đoạn bạn dán có câu "Đáp án: a) Đúng; b) Sai...".<br><span class="font-bold text-purple-700">MẸO TẠO KHUNG CODE:</span> Bọc đoạn mã bằng 3 dấu gạch chéo ngược (VD: ```html hoặc ```python) hệ thống sẽ tự sinh khung Code nền đen chuyên nghiệp.</p>
                   <textarea id="fastInputTF" class="w-full border border-purple-300 rounded-lg p-4 text-sm bg-white focus:ring-2 focus:ring-purple-500/30 outline-none transition-all custom-scrollbar whitespace-pre-wrap" rows="5" placeholder="Dán các câu Đúng/Sai vào đây...
Ví dụ:
25. Mạng máy tính sử dụng...
a) Ý 1...
b) Ý 2...
Đáp án: A. Đúng; B. Sai..."></textarea>
                   <button type="button" onclick="parseFastInput('tf')" class="mt-3 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-all flex items-center gap-2 text-sm active:scale-95">
                       <i class="fa-solid fa-wand-magic-sparkles"></i> Phân Tích & Điền Tiếp Nối
                   </button>
               </div>

               <div class="space-y-8 w-full">
                   <?php for($i=25; $i<=28; $i++): 
                       $q_data = $q_tf[$i] ?? null;
                       $layout = $q_data['layout'] ?? 'normal';
                       $has_py = strpos($layout, 'python') !== false;
                       $has_cpp = strpos($layout, 'cpp') !== false;
                   ?>
                   <div class="p-4 sm:p-6 bg-slate-50 border border-slate-200 rounded-2xl relative w-full box-border">
                       <div class="absolute -top-3 -left-3 bg-purple-800 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shadow-md border-2 border-white z-10"><?= $i ?></div>
                       
                       <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-3 gap-3 pl-4 sm:pl-0 w-full">
                           <span class="font-bold text-slate-800 flex items-center gap-2 shrink-0">Nội dung câu hỏi:
                               <button type="button" onclick="openMediaModal('tf_<?= $i ?>_content_input')" class="text-xs bg-purple-100 text-purple-700 hover:bg-purple-200 px-2 py-1 rounded font-bold transition whitespace-nowrap"><i class="fa-regular fa-image"></i> Ảnh</button>
                               <button type="button" onclick="openTableModal('tf_<?= $i ?>_content_input')" class="text-xs bg-blue-100 text-blue-700 hover:bg-blue-200 px-2 py-1 rounded font-bold transition whitespace-nowrap"><i class="fa-solid fa-table"></i> Bảng</button>
                               <button type="button" onclick="openCodeModal('tf_<?= $i ?>_content_input')" class="text-xs bg-slate-800 text-white hover:bg-slate-700 px-2 py-1 rounded font-bold transition whitespace-nowrap"><i class="fa-solid fa-code"></i> Code</button>
                           </span>
                           
                           <div class="flex items-center gap-4 bg-white border border-slate-300 px-4 py-2 rounded-xl text-sm font-bold shadow-sm w-full sm:w-auto box-border">
                               <span class="text-slate-500 mr-1"><i class="fa-solid fa-columns"></i> Cột Code:</span>
                               <label class="flex items-center cursor-pointer hover:text-indigo-600 transition">
                                   <input type="checkbox" name="tf_<?= $i ?>_show_py" value="1" onchange="toggleCodeCol('tf_<?= $i ?>', 'py', this.checked)" <?= $has_py ? 'checked' : '' ?> class="w-4 h-4 text-indigo-600 mr-2 rounded shrink-0 cursor-pointer"> Python
                               </label>
                               <div class="w-px h-4 bg-slate-300"></div>
                               <label class="flex items-center cursor-pointer hover:text-amber-600 transition">
                                   <input type="checkbox" name="tf_<?= $i ?>_show_cpp" value="1" onchange="toggleCodeCol('tf_<?= $i ?>', 'cpp', this.checked)" <?= $has_cpp ? 'checked' : '' ?> class="w-4 h-4 text-amber-600 mr-2 rounded shrink-0 cursor-pointer"> C++
                               </label>
                           </div>
                       </div>
                       
                       <div class="mb-4 w-full box-border">
                           <textarea id="tf_<?= $i ?>_content_input" name="tf_<?= $i ?>_content" required class="block w-full border border-slate-300 p-3 sm:p-4 rounded-xl text-sm focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition-all box-border" rows="3" placeholder="Nhập câu hỏi..."><?= htmlspecialchars($q_data['content'] ?? '') ?></textarea>
                       </div>
                       
                       <div id="code_cols_tf_<?= $i ?>" class="<?= ($has_py || $has_cpp) ? 'grid' : 'hidden' ?> <?= ($has_py && $has_cpp) ? 'grid-cols-1 xl:grid-cols-2' : 'grid-cols-1' ?> gap-4 mb-4 w-full box-border">
                           <div id="col_py_tf_<?= $i ?>" class="relative w-full <?= $has_py ? 'block' : 'hidden' ?>">
                               <div class="absolute top-2 left-3 text-xs font-black text-indigo-600 uppercase"><i class="fa-brands fa-python"></i> Python</div>
                               <div class="absolute top-2 right-2 flex gap-1">
                                   <button type="button" onclick="openMediaModal('tf_<?= $i ?>_left_input')" class="text-xs bg-white text-slate-500 border border-indigo-200 px-2 py-1 rounded shadow-sm hover:text-primary"><i class="fa-regular fa-image"></i></button>
                                   <button type="button" onclick="openTableModal('tf_<?= $i ?>_left_input')" class="text-xs bg-white text-slate-500 border border-indigo-200 px-2 py-1 rounded shadow-sm hover:text-blue-600"><i class="fa-solid fa-table"></i></button>
                                   <button type="button" onclick="openCodeModal('tf_<?= $i ?>_left_input')" class="text-xs bg-white text-slate-500 border border-indigo-200 px-2 py-1 rounded shadow-sm hover:text-slate-800"><i class="fa-solid fa-code"></i></button>
                               </div>
                               <textarea id="tf_<?= $i ?>_left_input" name="tf_<?= $i ?>_left" class="block w-full border border-indigo-200 bg-indigo-50/50 p-3 pt-10 rounded-xl text-sm focus:border-indigo-400 outline-none box-border font-mono whitespace-pre-wrap" rows="4" placeholder="Nhập code Python..."><?= htmlspecialchars($q_data['left_content'] ?? '') ?></textarea>
                           </div>
                           <div id="col_cpp_tf_<?= $i ?>" class="relative w-full <?= $has_cpp ? 'block' : 'hidden' ?>">
                               <div class="absolute top-2 left-3 text-xs font-black text-amber-600 uppercase"><i class="fa-solid fa-code"></i> C++</div>
                               <div class="absolute top-2 right-2 flex gap-1">
                                   <button type="button" onclick="openMediaModal('tf_<?= $i ?>_right_input')" class="text-xs bg-white text-slate-500 border border-amber-200 px-2 py-1 rounded shadow-sm hover:text-primary"><i class="fa-regular fa-image"></i></button>
                                   <button type="button" onclick="openTableModal('tf_<?= $i ?>_right_input')" class="text-xs bg-white text-slate-500 border border-amber-200 px-2 py-1 rounded shadow-sm hover:text-blue-600"><i class="fa-solid fa-table"></i></button>
                                   <button type="button" onclick="openCodeModal('tf_<?= $i ?>_right_input')" class="text-xs bg-white text-slate-500 border border-amber-200 px-2 py-1 rounded shadow-sm hover:text-slate-800"><i class="fa-solid fa-code"></i></button>
                               </div>
                               <textarea id="tf_<?= $i ?>_right_input" name="tf_<?= $i ?>_right" class="block w-full border border-amber-200 bg-amber-50/50 p-3 pt-10 rounded-xl text-sm focus:border-amber-400 outline-none box-border font-mono whitespace-pre-wrap" rows="4" placeholder="Nhập code C++..."><?= htmlspecialchars($q_data['right_content'] ?? '') ?></textarea>
                           </div>
                       </div>

                       <div class="mt-4 pt-4 border-t border-slate-200 w-full">
                           <div class="text-sm font-bold text-slate-500 mb-3 uppercase tracking-wider">Nhập 4 ý:</div>
                           <div class="space-y-3 w-full pl-0 sm:pl-2 border-l-2 border-purple-200 box-border">
                               <?php foreach(['a','b','c','d'] as $opt): 
                                   $is_checked = $q_data && $q_data['is_'.$opt.'_true'] == 1;
                               ?>
                               <div class="flex flex-col sm:flex-row items-stretch sm:items-center bg-white border border-slate-300 rounded-xl p-1.5 gap-2 group w-full box-border">
                                   <div class="flex w-full sm:flex-grow items-start min-w-0 pt-1">
                                       <span class="font-black text-slate-700 w-8 text-center bg-slate-100 rounded mx-1 py-1 shrink-0 mt-1"><?= $opt ?>)</span>
                                       <textarea id="tf_<?= $i ?>_<?= $opt ?>_input" name="tf_<?= $i ?>_<?= $opt ?>" required class="flex-grow border-none outline-none px-2 py-1.5 text-sm bg-transparent w-full min-w-0 resize-y custom-scrollbar whitespace-pre-wrap" rows="2" placeholder="Nội dung ý <?= $opt ?>..."><?= htmlspecialchars($q_data['part_'.$opt] ?? '') ?></textarea>
                                       <div class="flex flex-col gap-1 shrink-0 px-1 pt-0.5 border-l border-slate-100 bg-slate-50 rounded-r-lg">
                                           <button type="button" onclick="openMediaModal('tf_<?= $i ?>_<?= $opt ?>_input')" class="p-1.5 text-slate-400 hover:text-purple-600 transition" title="Chèn Ảnh"><i class="fa-regular fa-image"></i></button>
                                           <button type="button" onclick="openTableModal('tf_<?= $i ?>_<?= $opt ?>_input')" class="p-1.5 text-slate-400 hover:text-blue-600 transition" title="Chèn Bảng"><i class="fa-solid fa-table"></i></button>
                                           <button type="button" onclick="openCodeModal('tf_<?= $i ?>_<?= $opt ?>_input')" class="p-1.5 text-slate-400 hover:text-slate-800 transition" title="Chèn Code"><i class="fa-solid fa-code"></i></button>
                                       </div>
                                   </div>
                                   <label class="w-full sm:w-auto shrink-0 flex justify-center items-center gap-2 bg-slate-100 px-4 py-2 sm:py-4 rounded-lg cursor-pointer transition-colors has-[:checked]:bg-emerald-500 has-[:checked]:text-white text-slate-600 font-bold text-sm border border-transparent has-[:checked]:border-emerald-600 select-none box-border mr-1">
                                       <input type="checkbox" name="tf_<?= $i ?>_<?= $opt ?>_true" <?= $is_checked ? 'checked' : '' ?> class="w-4 h-4 text-emerald-600 border-slate-400 rounded focus:ring-0 shrink-0 cursor-pointer"> 
                                       <span>Ý NÀY ĐÚNG</span>
                                   </label>
                               </div>
                               <?php endforeach; ?>
                           </div>
                       </div>
                   </div>
                   <?php endfor; ?>
               </div>
           </div>

           <div class="sticky bottom-4 z-40 flex justify-center sm:justify-end w-full px-4 sm:px-0">
               <button type="button" onclick="submitAdminForm()" class="bg-slate-900 hover:bg-primary text-white font-black py-4 px-10 rounded-2xl shadow-2xl shadow-slate-900/40 hover:-translate-y-1 transition-all text-lg w-full sm:w-auto flex items-center justify-center gap-3 border border-slate-700">
                   <i class="fa-solid fa-cloud-arrow-up text-xl"></i> <?= $is_edit ? 'CẬP NHẬT ĐỀ THI' : 'LƯU ĐỀ THI MỚI' ?>
               </button>
           </div>
       </form>
   </div>

   <div id="mediaModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center opacity-0 transition-opacity duration-300">
       <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform scale-95 transition-transform duration-300" id="mediaModalContent">
           <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
               <h3 class="font-bold text-lg text-slate-800"><i class="fa-regular fa-images text-primary mr-2"></i> Chèn Hình Ảnh</h3>
               <button type="button" onclick="closeMediaModal()" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-xl"></i></button>
           </div>
           
           <div class="p-6">
               <input type="hidden" id="targetInputIdMedia" value="">
               
               <div class="flex border-b border-slate-200 mb-5">
                   <button type="button" onclick="switchMediaTab('upload')" id="tab_btn_upload" class="flex-1 py-2 font-bold text-sm text-primary border-b-2 border-primary transition">Tải file từ máy</button>
                   <button type="button" onclick="switchMediaTab('link')" id="tab_btn_link" class="flex-1 py-2 font-bold text-sm text-slate-500 border-b-2 border-transparent hover:text-slate-700 transition">Dán Link ảnh</button>
               </div>

               <div id="tab_upload" class="space-y-4">
                   <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:bg-slate-50 transition relative">
                       <input type="file" id="imageUploadInput" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="handleFileUpload(this)">
                       <i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-300 mb-2"></i>
                       <p class="text-sm font-medium text-slate-600">Click hoặc Kéo thả ảnh vào đây</p>
                       <p class="text-xs text-slate-400 mt-1">JPG, PNG, GIF, WEBP (Tối đa 5MB)</p>
                   </div>
                   <div id="uploadStatus" class="hidden text-sm text-center font-bold"></div>
               </div>

               <div id="tab_link" class="hidden space-y-4">
                   <div>
                       <label class="block text-sm font-bold text-slate-700 mb-1">Đường dẫn ảnh (URL):</label>
                       <input type="url" id="imageUrlInput" class="w-full border border-slate-300 px-3 py-2 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm box-border" placeholder="https://example.com/image.png">
                   </div>
                   <button type="button" onclick="insertLinkMedia()" class="w-full bg-primary hover:bg-secondary text-white font-bold py-2.5 rounded-lg transition text-sm shadow-md shadow-primary/30">Chèn vào nội dung</button>
               </div>
           </div>
       </div>
   </div>

   <div id="tableModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center opacity-0 transition-opacity duration-300 p-2">
       <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg flex flex-col max-h-[95vh] transform scale-95 transition-transform duration-300" id="tableModalContent">
           <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center shrink-0">
               <h3 class="font-bold text-lg text-slate-800"><i class="fa-solid fa-table text-blue-600 mr-2"></i> Tạo Bảng Dữ Liệu</h3>
               <button type="button" onclick="closeTableModal()" class="text-slate-400 hover:text-rose-500 transition p-1"><i class="fa-solid fa-xmark text-xl"></i></button>
           </div>
           <div class="px-6 py-3 bg-slate-100 flex gap-4 items-center border-b border-slate-200">
               <label class="font-bold text-sm text-slate-700">Chọn kiểu bảng:</label>
               <select id="tableColCount" onchange="resetTableRows()" class="border border-slate-300 rounded px-3 py-1.5 text-sm outline-none focus:ring-2 focus:ring-primary/20">
                   <option value="1" selected>1 Cột (Chỉ 1 ô rộng để chứa Code/Text)</option>
                   <option value="2">2 Cột (Chia 2 ô trái/phải)</option>
               </select>
           </div>
           <div class="p-4 overflow-y-auto flex-grow bg-slate-100 text-sm custom-scrollbar">
               <input type="hidden" id="targetInputIdTable" value="">
               <div id="tableRowsContainer" class="space-y-3"></div>
               <button type="button" onclick="addTableRow()" class="mt-4 bg-white border-2 border-dashed border-slate-300 hover:border-primary text-slate-500 hover:text-primary font-bold py-2.5 w-full rounded-xl shadow-sm transition"><i class="fa-solid fa-plus mr-1"></i> Thêm một dòng mới</button>
           </div>
           <div class="p-4 bg-white border-t border-slate-200 shrink-0">
               <button type="button" onclick="insertTable()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-md transition text-sm">Chèn Bảng Này Vào Nội Dung</button>
           </div>
       </div>
   </div>

   <div id="codeModal" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 hidden flex items-center justify-center opacity-0 transition-opacity duration-300 p-2">
       <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg flex flex-col max-h-[95vh] transform scale-95 transition-transform duration-300" id="codeModalContent">
           <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center shrink-0">
               <h3 class="font-bold text-lg text-slate-800"><i class="fa-solid fa-code text-slate-700 mr-2"></i> Chèn Đoạn Code Lập Trình</h3>
               <button type="button" onclick="closeCodeModal()" class="text-slate-400 hover:text-rose-500 transition p-1"><i class="fa-solid fa-xmark text-xl"></i></button>
           </div>
           <div class="p-4 overflow-y-auto flex-grow bg-slate-50 text-sm custom-scrollbar">
               <input type="hidden" id="targetInputIdCode" value="">
               <label class="block font-bold text-slate-700 mb-2">Chọn Ngôn ngữ / Định dạng:</label>
               <select id="codeLanguage" class="w-full border border-slate-300 px-3 py-2.5 rounded-xl mb-4 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none shadow-sm">
                   <option value="python">Python</option>
                   <option value="cpp">C++</option>
                   <option value="html">HTML / CSS</option>
                   <option value="pascal">Pascal</option>
                   <option value="text">Văn bản thường (Nền đen)</option>
               </select>
               <label class="block font-bold text-slate-700 mb-2">Dán nội dung Code:</label>
               <textarea id="codePasteArea" class="w-full border border-slate-300 p-4 rounded-xl text-sm bg-slate-800 text-emerald-400 font-mono outline-none focus:ring-2 focus:ring-primary/50 whitespace-pre-wrap custom-scrollbar" rows="8" placeholder="Dán mã lập trình vào đây...&#10;Giao diện sẽ giữ nguyên thụt lề khi hiển thị."></textarea>
           </div>
           <div class="p-4 bg-white border-t border-slate-200 shrink-0">
               <button type="button" onclick="insertCodeMedia()" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 rounded-xl shadow-md transition text-sm">Chèn Khung Code Vào Nội Dung</button>
           </div>
       </div>
   </div>

   <script>
       function autoWrapCode(text) {
           return text || "";
       }

       function submitAdminForm() {
           if(confirm('Bạn đã kiểm tra kỹ toàn bộ nội dung chưa?')) {
               const textareas = document.querySelectorAll('#createExamForm textarea');
               textareas.forEach(ta => {
                   if (ta.id === 'fastInputMCQ' || ta.id === 'fastInputTF' || ta.id === 'codePasteArea') return;
                   ta.value = autoWrapCode(ta.value);
               });
               document.getElementById('createExamForm').submit();
           }
       }

       function formatCodeBlocks(text) {
           return text.replace(/```([a-zA-Z\+]*)\n([\s\S]*?)```/gi, function(match, lang, code) {
               lang = (lang || 'text').toLowerCase();
               let label = "";
               if(lang === 'python' || lang === 'py') label = '<span class="text-[10px] font-bold text-indigo-400 border border-indigo-500/30 px-2 py-0.5 rounded uppercase mb-2 inline-block"><i class="fa-brands fa-python"></i> Python</span>\\n';
               else if(lang === 'cpp' || lang === 'c++' || lang === 'c') label = '<span class="text-[10px] font-bold text-amber-400 border border-amber-500/30 px-2 py-0.5 rounded uppercase mb-2 inline-block"><i class="fa-solid fa-code"></i> C++</span>\\n';
               else if(lang === 'html') label = '<span class="text-[10px] font-bold text-rose-400 border border-rose-500/30 px-2 py-0.5 rounded uppercase mb-2 inline-block"><i class="fa-brands fa-html5"></i> HTML</span>\\n';
               else if(lang === 'pascal') label = '<span class="text-[10px] font-bold text-blue-400 border border-blue-500/30 px-2 py-0.5 rounded uppercase mb-2 inline-block">Pascal</span>\\n';
               else if(lang && lang !== 'text') label = `<span class="text-[10px] font-bold text-slate-400 border border-slate-500/30 px-2 py-0.5 rounded uppercase mb-2 inline-block">${lang}</span>\\n`;
               
               let escapedCode = code.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
               return `\n<div class="bg-slate-800 text-emerald-400 p-4 rounded-lg mt-2 mb-2 font-mono text-sm overflow-x-auto whitespace-pre-wrap leading-relaxed">${label}<code>${escapedCode}</code></div>\n`;
           });
       }

       function parseFastInput(type) {
           let textId = type === 'mcq' ? 'fastInputMCQ' : 'fastInputTF';
           let text = document.getElementById(textId).value;
           if (!text.trim()) {
               alert("Vui lòng dán nội dung đề vào ô văn bản trước!");
               return;
           }

           let startIndex = type === 'mcq' ? 1 : 25;
           let endIndex = type === 'mcq' ? 24 : 28;
           let currentIdx = startIndex;

           for (let i = startIndex; i <= endIndex; i++) {
               let elContent = document.getElementById(`${type === 'mcq' ? 'mcq' : 'tf'}_${i}_content_input`);
               if (elContent && elContent.value.trim() === '') {
                   currentIdx = i;
                   break;
               }
               if (i === endIndex && elContent && elContent.value.trim() !== '') {
                   currentIdx = endIndex + 1; 
               }
           }

           if (currentIdx > endIndex) {
               alert("Đã điền đầy đủ các câu trong phần này! Vui lòng xoá bớt nội dung để nhập thêm.");
               return;
           }

           let blocks = [];
           let currentBlock = "";
           let lines = text.split('\n');
           
           let isNewQuestion = (line) => {
               if (/^\s*[A-Da-d][\.\)\:\/]\s/.test(line)) return false;
               if (/^\s*(Câu|Bài)\s+\d+\s*(?:\([^\)]*\))?\s*[\.\:\)\s]/i.test(line)) return true;
               if (/^\s*[\d\.\_]+\s*\([^\)]*\)\s*[\.\:\)]?\s+/i.test(line)) return true;
               if (/^\s*\d+\s*(?:\([^\)]*\))?\s*[\.\:\)]\s/i.test(line)) return true;
               if (/^\s*[\(\[]?(?:[\d\+]+[\.\_\+a-zA-Z]*){1,}\d+[\)\]]?\s*([\.\:\s]+|(?=[A-ZĐa-z<]|$))/i.test(line)) return true;
               
               return false;
           };

           let cleanPrefix = (text) => {
               let res = text.replace(/^\s*(Câu|Bài)\s+\d+\s*(?:\([^\)]*\))?\s*[\.\:\)\s\-\_]*/i, '');
               res = res.replace(/^\s*[\d\.\_]+\s*\([^\)]*\)\s*[\.\:\)\s\-\_]*/i, '');
               res = res.replace(/^\s*[\(\[]?(?:[\d\+]+[\.\_\+a-zA-Z]*){1,}\d+[\)\]]?\s*[\.\:\s\-\_]+/i, '');
               res = res.replace(/^\s*\d+\s*(?:\([^\)]*\))?\s*[\.\:\)\s\-\_]+/i, '');
               return res.trim();
           };

           for(let line of lines) {
               if (isNewQuestion(line) && currentBlock.trim() !== "") {
                   blocks.push(currentBlock);
                   currentBlock = line + "\n";
               } else {
                   currentBlock += line + "\n";
               }
           }
           if (currentBlock.trim() !== "") {
               blocks.push(currentBlock);
           }

           let filledCount = 0;

           blocks.forEach(block => {
               block = block.trim();
               if (!block) return;
               if (currentIdx > endIndex) return;

               let ansLineRegex = /(?:Đáp\s*án|Hướng\s*dẫn\s*giải)\s*:?\s*(.*)/i;
               let ansMatch = block.match(ansLineRegex);
               let ansString = ansMatch ? ansMatch[1].trim() : "";
               let cleanBlock = block.replace(ansLineRegex, '').trim();

               if (type === 'tf') {
                   let ansA = false, ansB = false, ansC = false, ansD = false;
                   if (ansString) {
                       let matches = ansString.match(/(đúng|sai|đ\b|s\b)/ig);
                       if (matches && matches.length >= 4) {
                           ansA = matches[0].toLowerCase().startsWith('đ');
                           ansB = matches[1].toLowerCase().startsWith('đ');
                           ansC = matches[2].toLowerCase().startsWith('đ');
                           ansD = matches[3].toLowerCase().startsWith('đ');
                       }
                   }

                   let optA_tf = "", optB_tf = "", optC_tf = "", optD_tf = "", qContent_tf = "";
                   let hasLowerAbcd = /(?:^|\n)\s*a[\.\)\/\:]\s/i.test(cleanBlock) && /(?:^|\n)\s*b[\.\)\/\:]\s/i.test(cleanBlock);

                   if (hasLowerAbcd) {
                       optA_tf = extractOptionMatch(cleanBlock, 'a', 'b');
                       optB_tf = extractOptionMatch(cleanBlock, 'b', 'c');
                       optC_tf = extractOptionMatch(cleanBlock, 'c', 'd');
                       optD_tf = extractOptionMatch(cleanBlock, 'd', '\\$');
                       qContent_tf = cleanBlock.replace(new RegExp(`(?:^|\\n)\\s*a[\\.\\/\\)\\:].*`, 'is'), '').trim();
                   } else {
                       let blockLines = cleanBlock.split('\n').map(l => l.trim()).filter(l => l !== '');
                       if (blockLines.length >= 4) {
                           optD_tf = blockLines.pop(); optC_tf = blockLines.pop(); optB_tf = blockLines.pop(); optA_tf = blockLines.pop();
                           qContent_tf = blockLines.join('\n');
                       } else {
                           qContent_tf = cleanBlock;
                       }
                   }

                   qContent_tf = cleanPrefix(qContent_tf);

                   let elContent = document.getElementById(`tf_${currentIdx}_content_input`);
                   if(elContent) {
                       elContent.value = autoWrapCode(qContent_tf);
                       document.getElementById(`tf_${currentIdx}_a_input`).value = autoWrapCode(optA_tf.replace(/^[A-Da-d][\.\)\:\/]\s*/, ''));
                       document.getElementById(`tf_${currentIdx}_b_input`).value = autoWrapCode(optB_tf.replace(/^[A-Da-d][\.\)\:\/]\s*/, ''));
                       document.getElementById(`tf_${currentIdx}_c_input`).value = autoWrapCode(optC_tf.replace(/^[A-Da-d][\.\)\:\/]\s*/, ''));
                       document.getElementById(`tf_${currentIdx}_d_input`).value = autoWrapCode(optD_tf.replace(/^[A-Da-d][\.\)\:\/]\s*/, ''));

                       document.getElementsByName(`tf_${currentIdx}_a_true`)[0].checked = ansA;
                       document.getElementsByName(`tf_${currentIdx}_b_true`)[0].checked = ansB;
                       document.getElementsByName(`tf_${currentIdx}_c_true`)[0].checked = ansC;
                       document.getElementsByName(`tf_${currentIdx}_d_true`)[0].checked = ansD;

                       elContent.closest('.bg-slate-50').classList.add('ring-2', 'ring-purple-400');
                       setTimeout(() => elContent.closest('.bg-slate-50').classList.remove('ring-2', 'ring-purple-400'), 1000);

                       filledCount++;
                       currentIdx++;
                   }
               } else {
                   let correctOptMatch = ansString.match(/(?:^|[^a-zA-ZđĐ])([A-D])(?:[^a-zA-ZđĐ]|$)/i);
                   let correctOpt = correctOptMatch ? correctOptMatch[1].toUpperCase() : null;

                   let optA_mcq = extractOptionMatch(cleanBlock, 'A', 'B');
                   let optB_mcq = extractOptionMatch(cleanBlock, 'B', 'C');
                   let optC_mcq = extractOptionMatch(cleanBlock, 'C', 'D');
                   let optD_mcq = extractOptionMatch(cleanBlock, 'D', '\\$');

                   let qContent_mcq = cleanBlock.replace(new RegExp(`(?:^|\\n)\\s*A[\\.\\/\\)\\:].*`, 'is'), '').trim();
                   
                   qContent_mcq = cleanPrefix(qContent_mcq);

                   let elContent = document.getElementById(`mcq_${currentIdx}_content_input`);
                   if(elContent) {
                       elContent.value = autoWrapCode(qContent_mcq);
                       document.getElementById(`mcq_${currentIdx}_a_input`).value = autoWrapCode(optA_mcq.replace(/^[A-Da-d][\.\)\:\/]\s*/, ''));
                       document.getElementById(`mcq_${currentIdx}_b_input`).value = autoWrapCode(optB_mcq.replace(/^[A-Da-d][\.\)\:\/]\s*/, ''));
                       document.getElementById(`mcq_${currentIdx}_c_input`).value = autoWrapCode(optC_mcq.replace(/^[A-Da-d][\.\)\:\/]\s*/, ''));
                       document.getElementById(`mcq_${currentIdx}_d_input`).value = autoWrapCode(optD_mcq.replace(/^[A-Da-d][\.\)\:\/]\s*/, ''));

                       let radios = document.getElementsByName(`mcq_${currentIdx}_correct`);
                       for(let r of radios) {
                           if(correctOpt && r.value === correctOpt) { 
                               r.checked = true; 
                           } else {
                               r.checked = false; 
                           }
                       }

                       elContent.closest('.bg-slate-50').classList.add('ring-2', 'ring-primary');
                       setTimeout(() => elContent.closest('.bg-slate-50').classList.remove('ring-2', 'ring-primary'), 1000);

                       filledCount++;
                       currentIdx++;
                   }
               }
           });

           if (filledCount > 0) {
               alert(`Thành công! Đã điền thêm ${filledCount} câu ${type === 'mcq' ? 'Trắc nghiệm' : 'Đúng/Sai'} (Bắt đầu từ câu ${startIndex}).\n(Những câu không có đáp án sẽ được tự động để trống tick chọn).`);
               document.getElementById(textId).value = ''; 
           } else {
               alert("Không tìm thấy cấu trúc câu hỏi hợp lệ. Hãy kiểm tra lại format.");
           }
       }

       function extractOptionMatch(text, current, next) {
           let regex;
           if (next === '\\$') {
               regex = new RegExp(`(?:^|\\n)\\s*${current}[\\.\\/\\)\\:]\\s*(.*)`, "is");
           } else {
               regex = new RegExp(`(?:^|\\n)\\s*${current}[\\.\\/\\)\\:]\\s*(.*?)\\s*(?=(?:^|\\n)\\s*${next}[\\.\\/\\)\\:])`, "is");
           }
           let match = text.match(regex);
           
           if (!match) {
               if (next === '\\$') {
                   regex = new RegExp(`\\s+${current}[\\.\\/\\)\\:]\\s*(.*)`, "is");
               } else {
                   regex = new RegExp(`\\s+${current}[\\.\\/\\)\\:]\\s*(.*?)\\s*(?=\\s+${next}[\\.\\/\\)\\:])`, "is");
               }
               match = text.match(regex);
           }
           return match ? match[1].trim() : '';
       }

       document.addEventListener('keydown', function(e) {
           if (e.key === 'Tab' && e.target.tagName.toLowerCase() === 'textarea') {
               e.preventDefault();
               var start = e.target.selectionStart;
               var end = e.target.selectionEnd;
               e.target.value = e.target.value.substring(0, start) + "    " + e.target.value.substring(end);
               e.target.selectionStart = e.target.selectionEnd = start + 4;
           }
       });

       function toggleCodeCol(prefix, lang, isChecked) {
           const col = document.getElementById('col_' + lang + '_' + prefix);
           const container = document.getElementById('code_cols_' + prefix);
           
           if (isChecked) {
               col.classList.remove('hidden'); col.classList.add('block');
           } else {
               col.classList.add('hidden'); col.classList.remove('block');
               col.querySelector('textarea').value = '';
           }
           
           const pyVisible = !document.getElementById('col_py_' + prefix).classList.contains('hidden');
           const cppVisible = !document.getElementById('col_cpp_' + prefix).classList.contains('hidden');
           
           if (pyVisible && cppVisible) {
               container.className = 'grid grid-cols-1 xl:grid-cols-2 gap-4 mb-4 w-full box-border';
           } else if (pyVisible || cppVisible) {
               container.className = 'grid grid-cols-1 gap-4 mb-4 w-full box-border';
           } else {
               container.className = 'hidden gap-4 mb-4 w-full box-border';
           }
       }

       function insertHTMLToTarget(htmlString, targetId) {
           const targetInput = document.getElementById(targetId);
           if(targetInput) {
               if(targetInput.value.length > 0 && !targetInput.value.endsWith('\n')) { targetInput.value += '\n'; }
               targetInput.value += htmlString;
               targetInput.classList.add('ring-2', 'ring-emerald-500', 'bg-emerald-50');
               setTimeout(() => { targetInput.classList.remove('ring-2', 'ring-emerald-500', 'bg-emerald-50'); }, 1000);
           }
       }

       function openMediaModal(t){document.getElementById('targetInputIdMedia').value=t;const m=document.getElementById('mediaModal'),c=document.getElementById('mediaModalContent');m.classList.remove('hidden');document.getElementById('imageUploadInput').value='';document.getElementById('imageUrlInput').value='';document.getElementById('uploadStatus').classList.add('hidden');setTimeout(()=>{m.classList.remove('opacity-0');c.classList.remove('scale-95');},10);}
       function closeMediaModal(){const m=document.getElementById('mediaModal'),c=document.getElementById('mediaModalContent');m.classList.add('opacity-0');c.classList.add('scale-95');setTimeout(()=>{m.classList.add('hidden');},300);}
       function switchMediaTab(t){if(t==='upload'){document.getElementById('tab_upload').classList.remove('hidden');document.getElementById('tab_link').classList.add('hidden');document.getElementById('tab_btn_upload').className="flex-1 py-2 font-bold text-sm text-primary border-b-2 border-primary";document.getElementById('tab_btn_link').className="flex-1 py-2 font-bold text-sm text-slate-500 border-b-2 border-transparent";}else{document.getElementById('tab_link').classList.remove('hidden');document.getElementById('tab_upload').classList.add('hidden');document.getElementById('tab_btn_link').className="flex-1 py-2 font-bold text-sm text-primary border-b-2 border-primary";document.getElementById('tab_btn_upload').className="flex-1 py-2 font-bold text-sm text-slate-500 border-b-2 border-transparent";}}
       function insertLinkMedia(){const u=document.getElementById('imageUrlInput').value.trim();if(!u)return;insertHTMLToTarget(`<img src="${u}" style="max-height:150px; border-radius:5px; margin-top:5px; border: 1px solid #e2e8f0;" />`,document.getElementById('targetInputIdMedia').value);closeMediaModal();}
       function handleFileUpload(i){if(!i.files||i.files.length===0)return;const f=i.files[0],s=document.getElementById('uploadStatus');if(f.size>5*1024*1024){alert("Max 5MB!");return;}s.classList.remove('hidden','text-rose-500','text-emerald-500');s.classList.add('text-primary');s.innerHTML='Đang tải...';const d=new FormData();d.append('file',f);fetch('index.php?action=ajax_upload_image',{method:'POST',body:d}).then(r=>r.json()).then(data=>{if(data.error){s.classList.replace('text-primary','text-rose-500');s.innerText=data.error;}else if(data.url){s.classList.replace('text-primary','text-emerald-500');s.innerText="Thành công!";setTimeout(()=>{insertHTMLToTarget(`<img src="${data.url}" style="max-height:150px; border-radius:5px; margin-top:5px; border: 1px solid #e2e8f0;" />`,document.getElementById('targetInputIdMedia').value);closeMediaModal();},500);}}).catch(e=>{s.innerText="Lỗi!";});}

       function resetTableRows() {
           document.getElementById('tableRowsContainer').innerHTML = '';
           addTableRow();
       }
       function openTableModal(t){
           document.getElementById('targetInputIdTable').value=t;
           document.getElementById('tableColCount').value = '1';
           resetTableRows();
           const m=document.getElementById('tableModal'),mc=document.getElementById('tableModalContent');
           m.classList.remove('hidden');
           setTimeout(()=>{m.classList.remove('opacity-0');mc.classList.remove('scale-95');},10);
       }
       function closeTableModal(){const m=document.getElementById('tableModal'),c=document.getElementById('tableModalContent');m.classList.add('opacity-0');c.classList.add('scale-95');setTimeout(()=>{m.classList.add('hidden');},300);}
       function addTableRow(){
           const cols = document.getElementById('tableColCount').value;
           const c=document.getElementById('tableRowsContainer');
           let h = '';
           if(cols === '1') {
               h=`<div class="bg-white border border-slate-200 rounded-lg p-2 table-row-item shadow-sm flex flex-col gap-2 relative pr-10">
                   <textarea class="w-full h-20 p-2 outline-none text-sm resize-none custom-scrollbar col1" placeholder="Dán nội dung hoặc mã Code vào đây..."></textarea>
                   <button type="button" onclick="this.closest('.table-row-item').remove()" class="absolute top-1/2 right-2 -translate-y-1/2 text-rose-300 hover:text-rose-500 p-2"><i class="fa-solid fa-trash"></i></button>
               </div>`;
           } else {
               h=`<div class="bg-white border border-slate-200 rounded-lg p-2 table-row-item shadow-sm flex gap-2 relative pr-10">
                   <textarea class="w-1/2 h-24 p-2 outline-none text-sm resize-none custom-scrollbar col1 border border-slate-200 rounded-lg" placeholder="Nội dung cột trái (VD: Code Python...)"></textarea>
                   <textarea class="w-1/2 h-24 p-2 outline-none text-sm resize-none custom-scrollbar col2 border border-slate-200 rounded-lg" placeholder="Nội dung cột phải (VD: Code C++...)"></textarea>
                   <button type="button" onclick="this.closest('.table-row-item').remove()" class="absolute top-1/2 right-2 -translate-y-1/2 text-rose-300 hover:text-rose-500 p-2"><i class="fa-solid fa-trash"></i></button>
               </div>`;
           }
           c.insertAdjacentHTML('beforeend',h);
       }
       function insertTable(){
           const cols = document.getElementById('tableColCount').value;
           const r=document.querySelectorAll('.table-row-item');
           if(r.length===0) return;
           
           let h=`\n<table class="w-full border-collapse border border-slate-300 mt-2 mb-2">\n  <tbody>\n`;
           
           r.forEach(ro=>{
               if(cols === '1') {
                   const e=ro.querySelector('.col1').value.trim().replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g,'<br>');
                   if(e) h+=`    <tr>\n      <td class="border border-slate-300 px-4 py-3 align-top">${e}</td>\n    </tr>\n`;
               } else {
                   const t=ro.querySelector('.col1').value.trim().replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g,'<br>');
                   const e=ro.querySelector('.col2').value.trim().replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g,'<br>');
                   if(t||e) h+=`    <tr>\n      <td class="border border-slate-300 px-4 py-3 w-1/2 align-top">${t}</td>\n      <td class="border border-slate-300 px-4 py-3 w-1/2 align-top">${e}</td>\n    </tr>\n`;
               }
           });
           h+=`  </tbody>\n</table>\n`;
           insertHTMLToTarget(h,document.getElementById('targetInputIdTable').value);
           closeTableModal();
       }

       function openCodeModal(targetId) {
           document.getElementById('targetInputIdCode').value = targetId;
           document.getElementById('codePasteArea').value = '';
           const modal = document.getElementById('codeModal');
           const content = document.getElementById('codeModalContent');
           modal.classList.remove('hidden');
           setTimeout(() => { modal.classList.remove('opacity-0'); content.classList.remove('scale-95'); }, 10);
       }
       function closeCodeModal() {
           const modal = document.getElementById('codeModal');
           const content = document.getElementById('codeModalContent');
           modal.classList.add('opacity-0'); content.classList.add('scale-95');
           setTimeout(() => { modal.classList.add('hidden'); }, 300);
       }
       function insertCodeMedia() {
           const code = document.getElementById('codePasteArea').value;
           const lang = document.getElementById('codeLanguage').value;
           if(!code.trim()) { alert("Vui lòng dán nội dung code vào ô!"); return; }
           
           const md = `\n\`\`\`${lang}\n${code}\n\`\`\`\n`;
           insertHTMLToTarget(md, document.getElementById('targetInputIdCode').value);
           closeCodeModal();
       }
   </script>
<?php 
endif; 
?>
</main>

<footer class="bg-slate-900 text-white py-8 mt-auto border-t-4 border-indigo-500 w-full relative z-10">
   <div class="max-w-7xl mx-auto px-4 flex flex-col items-center justify-center text-center">
       <div class="text-slate-400 mb-2 font-medium text-sm">Copyright 2026 - Được phát triển bởi</div>
       <a href="https://www.tiktok.com/@binhsubvip" target="_blank" rel="noopener noreferrer" 
          class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 border border-slate-700 hover:border-pink-500/50 px-5 py-2.5 rounded-xl text-white font-bold transition-all duration-300 group hover:shadow-[0_0_15px_rgba(236,72,153,0.3)]">
           <i class="fa-brands fa-tiktok text-pink-500 group-hover:scale-110 transition-transform text-lg"></i>
           BINHSUBVIP
       </a>
   </div>
</footer>

<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('sw.js');
        });
    }
</script>

</body>
</html>