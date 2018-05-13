<div class="color-block-container column-r1">
    <div class="color-block" style="height: 280px;">
        <h1><?= $this->pageTitle ?></h1>
        <div class="user-form">
            <?php
            $activeForm = $this->beginWidget('CActiveForm');

            ?>
            <div class="social-auth-buttons-cont">
                <?php $this->renderPartial('//user/_social_auth') ?>
            </div>

            <table>
                <tr>
                    <th><?= $activeForm->label($form, 'username', ['label' => 'Логин', 'id' => 'type_name']) ?></th>
                    <td>
                        <?= $activeForm->textField($form, 'username', ['id' => 'user_name']) ?>
                        <?= Html::error($form, 'username', 'errorLine') ?>
                    </td>
                </tr>

                <tr>
                    <th><?= $activeForm->label($form, 'password') ?></th>
                    <td>
                        <?= $activeForm->passwordField($form, 'password') ?>
                        <?= Html::error($form, 'password', 'errorLine') ?>
                    </td>
                </tr>
            </table>

            <div class="buttons">
                <?= $activeForm->checkBox($form, 'thirdComputer') ?>
                <?= Html::error($form, 'thirdComputer', 'errorLine') ?>
                <?= $activeForm->label($form, 'thirdComputer') ?>
                <br><br>

                <?= CHtml::submitButton('Войти', ['class' => 'bbutton']) ?>
                <br><br>
                <?= CHtml::link('Забыли пароль?', ['user/restore']) ?> &nbsp;&nbsp;
                <?= CHtml::link('Регистрация', ['user/registration']) ?>
                <br><br>
            </div>


            <?php $this->endWidget() ?>


        </div>
    </div>
</div>


<div class="color-block-container column-r2 order-add">
    <div class="color-block" style="height: 269px;">
        <?php $this->widget('CB', ['name' => 'user_login']) ?>
    </div>
</div>

<div class="clear"></div>
