<div class="admin">
    <form id="login">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="text" name="password" placeholder="Пароль" required>
        <div onclick="send('login','handler/account/login')" class="button login">Войти</div>
    </form>
    <div onclick="link('logout')" class="button logout">Выйти</div>
</div>

<form id="add">
    <input type="text" name="email"  placeholder="Email" required>
    <input type="text" name="name" placeholder="Имя пользователя" required>
    <input type="text" name="text" placeholder="Текст задачи" required>
    <div onclick="send('add','handler/add')" class="button send">Добавить</div>
</form>

<div class="sorting">
    <select onchange="sortBy()">
        <option value="1">По пользователю</option>
        <option value="2">По email</option>
        <option value="3">По статусу</option>
    </select>
</div>

<div class="list">
    <?foreach ($tasks as $row):
        if ($row['status'] == 1) $status = " active";
        else $status = "";
        ?>
        <div class="item" id="<?=$row['id']?>">
            <div class="left">
                <div class="email"><?=$row['email']?></div>
                <div class="name"><?=$row['name']?></div>
                <div class="text"><?=$row['text']?></div>
            </div>

            <div class="right<?=$itemEditVisible?>">
                <div onclick="edit(<?=$row['id']?>)" class="button edit">Р</div>
                <div onclick="status(this,<?=$row['id']?>)" class="button status<?=$status?>">С</div>
            </div>
        </div>
    <?endforeach;?>
</div>

<div class="pagination">
    <? if ($maxPage > 1):?>
        <?for ($i = 1; $i <= $maxPage; $i++):?>
            <a href="/page/<?=$i?>">
                <?if ($i == $page):?>
                    <div class="item active"><?=$i?></div>
                <?else:?>
                    <div class="item"><?=$i?></div>
                <?endif?>
            </a>
        <?endfor;?>
    <?endif;?>
</div>

<div class="wrapper"></div>
<div class="dialog">
    <form id="edit">
        <input type="hidden" name="id">
        <input type="text" name="text" placeholder="Текст задания">
        <div onclick="send('edit','handler/edit')" class="send">Сохранить</div>
    </form>
</div>

<div class="message">Message</div>

<script>
    setSelect(<?=$_SESSION['sorting']?>);
</script>
