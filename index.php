<style>
    form{ margin: 50px 30%; width: 40%; background-color: #eee; padding: 20px;}
    button{padding: 10px 20px; background-color: #999; color: #fff; border-radius: 5px; -webkit-border-radius: 5px;
    -moz-border-radius: 5px; cursor: pointer; width: 20%;}
    button:hover{background-color: #777}
    input[type=file]{padding: 10px 20px; color: #333;border-radius: 5px; -webkit-border-radius: 5px;
        -moz-border-radius: 5px; background-color: #dedede; width: 79%; margin-top: 10px}
</style>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="attach[]">
    <input type="file" name="attach[]">
    <input type="file" name="attach[]">
    <input type="file" name="attach[]">
    <!-- <input type="file" name="attach">-->
    <button name="send"> Anexar</button>
</form>
