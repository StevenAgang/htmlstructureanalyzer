            <h2>HTML tags analyzer</h2>
            <table>
                <tr>
                    <th>HTML tags</th>
                    <th>Number of appearances</th>
                </tr>
<?php if(isset($count) && !empty($count)): ?>
<?php foreach($count as $match): ?>
                <tr>
                    <td><?=$match['tags']?></td>
                    <td><?=$match['count']?></td>
                </tr>
<?php endforeach; ?>
<?php endif;?>
            </table>