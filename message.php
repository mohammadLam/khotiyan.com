<?php
    include "inc/header.php";
    include "class/messageClass.php";
    $msg = new Message();

    if (isset($_GET['msgid'])) {
        $id = $_GET['msgid'];
        $delete_msg = $msg->delete_msg($id);
    }
?>

<div class="container">
    <h3 class="pt-3">ব্যবহারকারীর মতামত, অভিযোগ বাক্সঃ</h3>
    <?php
    if (isset($delete_msg)){
        echo $delete_msg;
    }
    ?>
    <div class="row">
        <div class="col">
            <form method="post">
                <table class="table table-sm table-responsive-sm table-striped table-borderless text-center table-hover bg-light shadow">
                    <tr class="bg-dark text-white">
                        <th>নং</th>
                        <th>ব্যাবহারকারীর নাম</th>
                        <th>ব্যাবহারকারীর মেইল</th>
                        <th>বিষয়</th>
                        <th>তারিখ</th>
                        <th>অ্যাকশন</th>
                    </tr>
                    <tbody>
                    <?php
                    $messagelist = $msg->messagelist();
                    if ($messagelist) {
                        $i = 0;
                        while ($result = $messagelist->fetch_assoc()) {
                            $i++; ?>
                            <tr>
                                <td><?php echo $fm->engToBangla($i); ?></td>
                                <td><?php echo $result['username']; ?></td>
                                <td><?php echo $result['email']; ?></td>
                                <td><?php echo $result['subject']; ?></td>
                                <td><?php echo $fm->engToBangla($result['date']); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-primary btn-sm" href="replaymessage.php?msgid=<?php echo $result['id'];?>"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-danger btn-sm" href="?msgid=<?php echo $result['id'];?>"><i class="fa fa-remove"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>