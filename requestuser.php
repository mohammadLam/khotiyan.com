<?php
include "inc/header.php";
// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}


if(isset($_GET['confirm']) && $_GET['confirm'] != ''){
    $userid = $_GET['confirm'];
    $confirmUser = $user->confirmUser($userid);
}

if(isset($_GET['remove']) && $_GET['remove'] != ''){
    $userid = $_GET['remove'];
    $declineRequest = $user->declineRequest($userid);
}
?>

<div class="container">
    <h3 class="pt-3">ইউজার হওয়ার জন্য আবেদন করেছেন</h3>
    <?php
        if (isset($confirmUser)) {
            echo $confirmUser;
        }
        elseif(isset($declineRequest)){
            echo $declineRequest;
        }
    ?>
    <div class="row">
        <div class="col">
                <?php
                    $getRequestUser = $user->getRequestUser();
                    if($getRequestUser){
                        echo '<table class="table table-sm table-striped table-borderless text-center table-responsive-sm table-hover bg-light shadow">
                        <tr class="bg-dark text-white py-2">
                            <th>নং</th>
                            <th>নাম</th>
                            <th>মেইল</th>
                            <th>ঠিকানা</th>
                            <th>ফোন</th>
                            <th>অ্যাকশন</th>
                        </tr>';
                        $i = 0;
                        while($result = $getRequestUser->fetch_assoc()){$i++;?>
                        <tr>
                            <td><?php echo $fm->engToBangla($i);?></td>
                            <td><?php echo $result['username'];?></td>
                            <td><?php echo $result['email'];?></td>
                            <td><?php echo $result['address'];?></td>
                            <td><?php echo $fm->engToBangla($result['phone']);?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-primary btn-sm" href="?confirm=<?php echo $result['id']; ?>"><i class="fa fa-check"></i></a>
                                    <a class="btn btn-danger btn-sm"  href="?remove=<?php echo $result['id']; ?>"><i class="fa fa-remove"></i></a>
                                </div>
                            </td>
                        </tr>
                <?php   }   
            
                }else{
                    echo "<h4 class='text-center pt-5'>কোন রিকোয়েস্ট নেই</h4>";
                }?>
                
            </table>
        </div>
    </div>
</div>
<?php include "inc/footer.php";?>