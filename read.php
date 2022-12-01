<?php
include 'functions.php';

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM users ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Fetch the records so we can display them in our template.
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_users = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Users</h2>
	<a href="create.php" class="create-users">Create User</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>First Name</td>
                <td>Middle Name</td>
                <td>Last Name</td>
                <td>Email</td>
                <td>ID Number</td>
                <td>Course</td>
                <td>Password</td>
                <td>Gender</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $users): ?>
            <tr>
                <td><?=$users['id']?></td>
                <td><?=$users['fname']?></td>
                <td><?=$users['mname']?></td>
                <td><?=$users['lname']?></td>
                <td><?=$users['email']?></td>
                <td><?=$users['idnum']?></td>
                <td><?=$users['course']?></td>
                <td><?=$users['password']?></td>
                <td><?=$users['gender']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$users['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$users['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_users): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>