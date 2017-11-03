<?php include ("header.php");
$resAct[0]=2;
if(isset($_POST['delete'])){
    $resAct = $user->deleteTodo($_POST['tId']);
}
if(isset($_POST['showTask'])){
    header('Location: http://localhost/test-project/task.php?tId='.$_POST['tId']);
}
?>
    <div class="container tbl-cnt mt-10">
        <div class="row justify-content-center">
            <div class="col">
                <?php echo $user->resMethod($resAct[0],$resAct[1]);?>
                    <table class="table table-hover mt-10">
                        <thead>
                        <tr><th colspan="3"><p class="font-weight-bold">To Do Lists</p></th></tr>
                        </thead>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $todolists = $user->getTodolists($_SESSION['userId']);
                        if($todolists!=NULL){
                            if($_SESSION['userId']!='' && $_SESSION['userId']!=NULL){
                                $cnt = 0;
                                foreach($todolists as $todo){
                                    $txtstatus = $user->getTodolistStatus($todo);
                                    ?>
                                    <form action="dashboard.php" method="post"  name="todolist" >
                                        <tr  <?php echo($txtstatus=="Done")?"style='background-color:#fff;color:#0ad343;font-weight:bold'":""; ?>>
                                            <th scope="row"><?php echo $cnt; ?></th>
                                            <td><?php echo $todo['title']; ?></td>
                                            <td><?php echo $todo['description']; ?></td>
                                            <td><?php echo $txtstatus; ?></td>
                                            <td>
                                                <input type="hidden" name="tId" value="<?php echo $todo['id']; ?>">
                                                <?php
                                                $isHave = $user->checkHaveTask($todo['id']);
                                                if(!$isHave){
                                                    ?>
                                                    <button type="submit" class="btn btn-danger btn-rounded" name="delete">Delete</button>
                                                <?php } ?>
                                                <button type="submit" class="btn btn-info btn-rounded" name="showTask">Show task</button>
                                            </td>
                                        </tr>
                                    </form>
                                    <?php
                                    $cnt++;
                                }
                            }
                            else{
                                ?>
                                <tr><td colspan="5">you dont have permission to show to do list .</td>
                                </tr>
                                <?php
                            }
                        }
                        else{
                            ?>
                            <tr><td colspan="5">This user dont have any to do list .</td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>

<?php include ("footer.php");?>