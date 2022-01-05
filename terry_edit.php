<?php
require __DIR__ . '/parts/__connect_db.php';
// require __DIR__ . '/parts/__nolog.php';
$title = '修改資料';

if (!isset($_GET['sid'])) {
    header('Location: terry_animal_touch.php');
    exit;
}

$sid = intval($_GET['sid']);
$row = $pdo->query("SELECT * FROM `animal_touch` WHERE sid=$sid")->fetch();
if (empty($row)) {
    header('Location: terry_animal_touch.php');
    exit;
}

$row['actTime_start'] = date('Y-m-d\TH:i:s', strtotime($row['actTime_start']));
$row['actTime_end'] = date('Y-m-d\TH:i:s', strtotime($row['actTime_end']));


?>
<?php include __DIR__ . '/parts/__html_head.php' ?>
<!-- <?php include __DIR__ . '/parts/__navbar.php' ?> -->
<style>
    form .form-text {
        color: red;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改活動資料</h5>

                    <form name="form1" onsubmit="sendData(); return false;">
                        <input type="hidden" name="sid" value="<?= $row['sid'] ?>">
                        <div class="mb-3">
                            <label for="actName" class="form-label">活動名稱</label>
                            <input type="text" class="form-control" id="actName" name="actName" value="<?= htmlentities($row['actName']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="actTime_start" class="form-label">開始時間</label>
                            <input type="datetime-local" class="form-control" id="actTime_start" name="actTime_start" value="<?= $row['actTime_start'] ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="actTime_end" class="form-label">結束時間</label>
                            <input type="datetime-local" class="form-control" id="actTime_end" name="actTime_end" value="<?= $row['actTime_end'] ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="reserPeop" class="form-label">已預約人數</label>
                            <input type="text" class="form-control" id="reserPeop" name="reserPeop" value="<?= $row['reserPeop'] ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="introduce" class="form-label">活動簡介</label>
                            <textarea class="form-control" name="introduce" id="introduce" cols="30" rows="3"><?= $row['introduce'] ?></textarea>

                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">活動位置</label>
                            <textarea class="form-control" name="location" id="location" cols="30" rows="1"><?= $row['location'] ?></textarea>

                            <div class="form-text"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">修改</button>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">資料錯誤</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/parts/__scripts.php' ?>
<script>
    const actName = document.querySelector('#actName');
    const actTime_start = document.querySelector('#actTime_start');
    const actTime_end = document.querySelector('#actTime_end');
    const reserPeop = document.querySelector('#reserPeop');
    const introduce = document.querySelector('#introduce');
    const locat = document.querySelector('#location');


    const modal = new bootstrap.Modal(document.querySelector('#exampleModal'));

    function sendData() {

        actName.nextElementSibling.innerHTML = '';
        // actTime_start.nextElementSibling.innerHTML = '';
        // actTime_end.nextElementSibling.innerHTML = '';
        // reserPeop.nextElementSibling.innerHTML = '';
        // introduce.nextElementSibling.innerHTML = '';
        // location.nextElementSibling.innerHTML = '';

        let isPass = true;
        // 檢查表單的資料
        if (actName.value.length < 2) {
            isPass = false;
            actName.nextElementSibling.innerHTML = '請輸入正確的資訊';
        }




        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('terry_edit_api.php', {
                    method: 'POST',
                    body: fd,
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('修改成功');
                        location.href = 'terry_animal_touch.php';
                    } else {

                        document.querySelector('.modal-body').innerHTML = obj.error || '資料修改發生錯誤';
                        modal.show();
                    }
                })
        }

    }
</script>
<?php include __DIR__ . '/parts/__html_foot.php' ?>