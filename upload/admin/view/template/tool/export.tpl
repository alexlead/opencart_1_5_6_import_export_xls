<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
   
    <div class="content">
     <h3>Получить данные из БД</h3>
      <hr>
          <div class="buttons"><a onclick="location='<?php echo $export; ?>'" class="button"><span><?php echo $button_export; ?></span></a> | <a onclick="location='<?php echo $export_cat; ?>'" class="button"><span><?php echo $button_export_cat; ?></span></a> | <a onclick="location='<?php echo $export_prod; ?>'" class="button"><span><?php echo $button_export_prod; ?></span></a></div>
          <br/>
          <br/>
          <hr/>
<h3>Загрузить данные в БД</h3>
      <hr/>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td colspan="2"><?php echo $entry_description; ?></td>
          </tr>
          <tr>
            <td width="25%"><?php echo $entry_restore; ?></td>
            <td><input type="file" name="upload" /></td>
          </tr>
          <tr>
              <td colspan='2'>
                 <p>Таблица</p>
                  <label><input type="radio" name="uploading_table" value="1" checked="checked">Все таблицы (файл содежит 8 вкладок с данными о категориях и товарах)</label><br/>
                  <label><input type="radio" name="uploading_table" value="2">Только категории (файл с одной вкладкой - "Категории")</label><br/>
                  <label><input type="radio" name="uploading_table" value="3" disabled="disabled">Только товары (файл содержит 7 вкладок информации о продукте)</label><br/>
              </td>
          </tr>          <tr>
              <td colspan='2'>
                 <p>Метод</p>
                  <label><input type="radio" name="uploading_way" value="1">Удалить все данные и внести новые (перед внесением данных таблица очищается)</label><br/>
                  <label><input type="radio" name="uploading_way" value="2" checked="checked">Добавлять данные в таблицы как новые (таблица не очищается, позиции которых нет в таблице добавляются как новые) </label><br/>
              </td>
          </tr>

       
        </table>
      </form>
      <div><a onclick="$('#form').submit();" class="button"><span><?php echo $button_import; ?></span></a></div>     
      
    </div>

      <p class="author"><strong>Module created by Alex Lead (<a href="mailto:a.lead@yandex.ru">a.lead@yandex.ru</a>)</strong></p>
    
  </div>
</div>
<?php echo $footer; ?>