<!DOCTYPE html>
<html>
<head>
    <title>Student Info Form</title>
</head>
<body>
    <h2>Student Info Form</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <?php if (session('errors')): ?>
        <ul style="color: red;">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/student/save" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <label>Name:</label><input type="text" name="student_name"><br>
        <label>Roll:</label><input type="text" name="roll"><br>
        <label>Class:</label><input type="text" name="class"><br>
        <label>ESIF:</label><input type="text" name="esif"><br>
        <label>Section:</label>
		<select name="section">
		    <option value="">Select Section</option>
		    <option value="General">General</option>
		    <option value="BM">BM</option>
		</select><br>
        <label>Date of Birth:</label><input type="date" name="dob"><br>
        <label>Phone:</label><input type="text" name="phone"><br>
        <label>Birth Reg. Card:</label><input type="file" name="birth_registration_pic"><br>
        <label>Father ID:</label><input type="file" name="father_id_pic"><br>
        <label>Mother ID:</label><input type="file" name="mother_id_pic"><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
