<form method="post" action="/partner/applications/offer">
    <label for="id">Application id to make offer to:</label>
    <input type="number" name="id" id="id" min="1" step="1" required>
    <input type="submit" name="offer" value="Submit">
</form>


<a href="/">Back</a>
<br>
<br>
<table>
    <?php foreach ($applications as $application) : ?>
        <tr>
            <td>
                <?php
                $partner = ($application->partner_id == 1) ? 'A' : 'B';
                echo $application->application_id . ' | ' .
                    $application->email . ' | ' .
                    $application->sum . ' | ' .
                    $partner . ' | ' .
                    $application->type; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>