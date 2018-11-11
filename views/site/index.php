<?php

/* @var $this yii\web\View */
use yii\grid\GridView;
//use yii\data\ActiveDataProvider;
use app\models\Logs;


$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1></h1>

        <p class="lead"></p>

        <p><a class="btn btn-lg btn-success" href="?pressed=true">Згенерувати дані</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Усі записи з Бази Даних</h2>
				
				<?php foreach($logs as $item): ?>
                <p><?php echo $item->time . ' ' . $item->key; ?></p>
				<?php endforeach; ?>
				
                
            </div>
            <div class="col-lg-8">
                <h2>Через віджет GridView (+формат дати)</h2>

				
                
				<?= GridView::widget([
						'dataProvider' => $dataProvider,
						
						//'pager' => ['maxButtonCount' => 5],
						
						'columns' => [
							'id',
							['attribute' => 'time', 'format' => ['date', 'php:Y-m-d']],
							'key',
							
									],
					]); ?>
					

                
            </div>
            
        </div>

    </div>
</div>
