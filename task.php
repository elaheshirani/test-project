<?php include ("header.php");
$resAct[0]=2;
if(isset($_POST['delete'])){
    $_GET['tId'] = $_POST['tId'];
    $resAct = $user->deleteTask($_POST['taskId']);
}
if(isset($_POST['edit'])){
    $_GET['tId'] = $_POST['tId'];
    $resAct = $user->editTask($_POST['taskId'],$_POST['status']);
}
?>
    <div class="container tbl-cnt mt-10">
        <div class="row justify-content-center">
            <div class="col">
                <?php echo $user->resMethod($resAct[0],$resAct[1]);?>
                    <table class="table table-hover mt-10">
                        <thead>
                        <tr>
                            <th colspan="4"><p class="font-weight-bold">To Do Lists</p></th>
                            <th ><a href="http://localhost/test-project/dashboard.php" class="btn btn-pink">back</a></th>
                        </tr>
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
                        if($_SESSION['userId']!='' && $_SESSION['userId']!=NULL){
                            $tasks = $user->getTasks($_GET['tId']);
                            if($tasks!=NULL){
                                $cnt = 0;
                                foreach($tasks as $todo){
                                    ?>
                                    <form action="task.php" method="post"  name="register" >
                                        <tr  <?php echo($todo['status']==2)?"style='background-color:#fff;color:#0ad343;font-weight:bold'":""; ?>>
                                            <th scope="row"><?php echo $cnt; ?></th>
                                            <td><?php echo $todo['title']; ?></td>
                                            <td><?php echo $todo['description']; ?></td>
                                            <td>
                                                <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="inlineFormCustomSelect" name="status">
                                                    <option >Choose...</option>
                                                    <option value="1" <?php echo($todo['status']==1)?"selected":""; ?>>New</option>
                                                    <option value="2" <?php echo($todo['status']==2)?"selected":""; ?>>Done</option>
                                                    <option value="3" <?php echo($todo['status']==3)?"selected":""; ?>>Canceled</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="hidden" name="taskId" value="<?php echo $todo['id']; ?>">
                                                <input type="hidden" name="tId" value="<?php echo $_GET['tId']; ?>">
                                                <button type="submit" class="btn btn-danger btn-rounded" name="delete">Delete</button>
                                                <button type="submit" class="btn btn-secondary btn-rounded" name="edit">Edit</button>
                                            </td>
                                        </tr>
                                    </form>
                                    <?php
                                    $cnt++;
                                }
                            }
                            else{
                                ?>
                                <tr><td colspan="5">This todolist dont have any task .</td>
                                </tr>
                                <?php
                            }
                        }
                        else{
                            ?>
                            <tr><td colspan="5">you dont have permission to show task .</td>
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