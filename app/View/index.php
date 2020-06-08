<form method="post" action="/application/create">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <label for="sum">Sum:</label>
    <input type="number" name="sum" id="sum" min="1" step="0.01" required>
    <input type="submit" name="add" value="Submit">
</form>
<a href="/partner/applications">Applications</a>
<?php if(isset($error)) echo $error; ?>