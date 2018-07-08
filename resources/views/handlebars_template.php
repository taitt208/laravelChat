<script id="messages-template" type="text/x-handlebars-template">
    {{#each messages}}
<!--    <div class="msg">-->
<!--        <div class="time">{{time}}</div>-->
<!--        <div class="details">-->
<!--            <span class="user">{{user}}</span>: <span class="text">{{text}}</span>-->
<!--        </div>-->
<!--    </div>-->
        <li class="sent">
            <img src="<?php echo $user->image ?>" alt="" />
            <p>{{text}}</p>
        </li>
    {{/each}}
</script>