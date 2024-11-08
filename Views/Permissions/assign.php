<h1>Asignar rol</h1>
<form action="" id="form-data">
    <input type="text" name="roleId" value="<?php echo $data1['roleId']; ?>">

    <table>
        <thead>
        <tr>
            <th>Module</th>
            <th>Create</th>
            <th>Read</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $n=1;
        /** @var Permissions $data1 */
        $modules = $data1['modules'];
        for ($i=0; $i < count($modules); $i++) {
        $permissions = $modules[$i]['permissions'];
        $cCheck = $permissions['c'] == 1 ? " checked " : "";
        $rCheck = $permissions['r'] == 1 ? " checked " : "";
        $uCheck = $permissions['u'] == 1 ? " checked " : "";
        $dCheck = $permissions['d'] == 1 ? " checked " : "";

        $moduleId = $modules[$i]['moduleId'];
        ?>
            <tr>
        <td>
            <?php echo $n; ?>
            <input type="hidden" name="module[<?php echo $i; ?>][moduleId]" value="<?php echo $moduleId; ?>">
        </td>
        <td> <?php echo $modules[$i]['moduleName']; ?></td>
            <td><input type="checkbox" name="module[<?php echo $i; ?>][c]" <?php echo $cCheck ?>></td>
            <td><input type="checkbox" name="module[<?php echo $i; ?>][r]" <?php echo $rCheck ?>></td>
            <td><input type="checkbox" name="module[<?php echo $i; ?>][u]" <?php echo $uCheck ?>></td>
            <td><input type="checkbox" name="module[<?php echo $i; ?>][d]" <?php echo $dCheck ?>></td>
            </tr>
            <?php
            $n++;
        }
        ?>
        </tbody>
    </table>
    <button>Save</button>
</form>

<script>
    form = document.getElementById('form-data')

    form.addEventListener('submit', function(e){
        e.preventDefault()
        var info = new FormData(form);
        let obj = Object.fromEntries(info.entries());
        console.log(obj)

        fetch('http://localhost/insider/permissions/assignPermissions', {
            method: 'POST', // or 'PUT'
            body: info,
        })
            .then((response) => response.json())
            .then((data) => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });

    })
</script>