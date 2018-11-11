<?php

namespace app\models;

use yii\db\ActiveRecord;


class Logs extends ActiveRecord
{
    
    public static function tableName()
    {
        return '{{logs}}';
    }
	
	public function rules()
	{
		return [
			[['time', 'key'], 'required'],
		];
	}
	
	/**
	* створює 200 нових тестових записів,
	* де значення time має бути в періоді часу за останній рік
	* і значення key - це 8 випадкових символів латинського алфавіту
	*/
	public static function generate200items()
	{
		
		self::generateTimeDateLastYear();
		
		for ($i = 0; $i < 200; $i++)
		{
			$log = new Logs();
			$log->key = self::generateRandString();
			$log->time = self::generateTimeDateLastYear();;
			$log->save();
		}
		
		
	}
	
	/**
	* Генерує рядок із 8 символів
	*/
	public static function generateRandString()
	{
		return substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',8)),0,8);
	}
	
	/**
	* Генерує дату за останній рік (у форматі timestamp - в секундах)
	*/
	public static function generateTimeDateLastYear()
	{
		$now = time();
		$start = $now - 31556926;
		
		return rand($start, $now);
	}
	
}
