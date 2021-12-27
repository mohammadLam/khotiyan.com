<?php
include "inc/header.php";

// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}

//get delete user id from url
if ($user_role == 3 && isset($_GET['deluserId'])) {
    $userid = $_GET['deluserId'];
    $deleteuserById = $user->deleteuserById($userid);
}?>

<div class="container">
    <h3 class="pt-3">ইউজারের তালিকাঃ</h3>
    <?php
        if (isset($deleteuserById)) {
            echo $deleteuserById;
        }
    ?>
    <p class="success"></p>
    <p class="error"></p>

    <div class="row">
        <div class="col">
            <form>
                <table class="table table-sm table-striped table-borderless text-center table-responsive-sm table-hover bg-light shadow">

                    <tr class="bg-dark text-white">
                        <th>নং</th>
                        <th>ইউজারের নাম</th>
                        <th>ইউজারের মেইল</th>
                        <th>ইউজারের ফোন</th>
                        <th>ইউজারের ঠিকানা</th>
                        <th>ইউজারের পদ</th>
                        <th>ব্যালেন্স</th>
                        <th>ডিলিট</th>
                    </tr>

                    <?php

                    $getUserList = $user->getUserList();
                    $i = 0;
                    if ($getUserList) {
                        while ($result = $getUserList->fetch_assoc()) {$i++; ?>

                            <tr>
                                <td><?php echo $fm->engToBangla($i);?></td>
                                <td><?php echo $result['username'];?></td>
                                <td><?php echo $result['email'];?></td>
                                <td><?php echo $fm->engToBangla($result['phone']);?></td>
                                <td><?php echo $result['address'];?></td>
                                <td><?php echo $fm->typeOfUser($result['role']);?></td>
                                <td width="150px">
                                    <input data-amount="<?php echo $result['id']; ?>" style="width: 80px; border: none; font-size: 18px; background: none;" class="amount" type="text" value="<?php echo $fm->engToBangla($result['point']); ?>">৳
                                    <button class="btn btn-sm addamount" data-id="<?php echo $result['id']; ?>"><i class="fa fa-refresh"></i></button>
                                </td>
                                <td><a class="btn btn-danger btn-sm" href="?deluserId=<?php echo $result['id']; ?>"><i class="fa fa-trash"></i></a></td>

                            </tr>

                    <?php   }   }?>

                </table>

            </form>

        </div>

    </div>

    <a href="createUser.php">
        <div class="plus_btn">ইউজার তৈরি করুন</div>
    </a>

</div>

<?php include "inc/footer.php";?>

<script type="text/javascript" src="jquery.min.js"></script>

<script type="text/javascript">



    $(document).ready(function () {

        $(document).on("click", ".addamount", function (e) {
            e.preventDefault();
            var amount = $(this).siblings().val();
            var userid = $(this).data("id");
            var amount = replaceNumbers(amount);

            $.ajax({

                url: "ajax/update.php",
                type: "POST",
                data: {id: userid, bdt: amount, type: 'update_amount'},
                success: function (data) {

                    if (data == 1) {
                        $(".success").slideUp();
                        $(".success").html("ইউজারের টাকা যোগ করা হয়েছে").slideDown();
                        $(".error").slideUp();
                    } else {
                        $(".error").html(data).slideDown();
                        $(".success").slideUp();
                    }
                }
            });
        });



        function replaceEngToBanNumbers(input) {

            var numbers = {
                0: '০',
                1: '১',
                2: '২',
                3: '৩',
                4: '৪',
                5: '৫',
                6: '৬',
                7: '৭',
                8: '৮',
                9: '৯'
            };

            //console.log("replaceNumbers", input);

            var output = [];
            for (var i = 0; i < input.length; i++) {
                if (numbers.hasOwnProperty(input[i])) {
                    output.push(numbers[input[i]]);
                } else {
                    output.push(input[i]);
                }
            }
            return output.join('').toString();
        }

        function replaceNumbers(input) {
            var numbers = {

                '০': 0,
                '১': 1,
                '২': 2,
                '৩': 3,
                '৪': 4,
                '৫': 5,
                '৬': 6,
                '৭': 7,
                '৮': 8,
                '৯': 9

            };

            var output = [];
            for (var i = 0; i < input.length; i++) {
                if (numbers.hasOwnProperty(input[i])) {
                    output.push(numbers[input[i]]);
                } else {
                    output.push(input[i]);
                }
            }
            return output.join('').toString();
        }



        $(".amount").on("input", function () {
            var hi = $(this).val();
            $(this).val(replaceEngToBanNumbers(hi));
        });
    });
</script>