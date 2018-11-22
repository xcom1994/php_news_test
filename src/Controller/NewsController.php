<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\News;

class NewsController extends AbstractController
{
    /**
     * @Route("/route", name="list of news")
     */
    public function news_list()
    {
		//Создаем наш буффер вывода
		$html = "<h1>Новости</h1>";
		
		//Получаем список новостей
        $list = $this->getDoctrine()->getRepository(News::class)->findAll();
		
		//Добавляем в буфер отформатированные ссылки на новости
		foreach ($list as $id => $news) {
			$date = date_format ($news->getdate(),'d.m.Y');
			$html .= sprintf("<p><a href='route/news/%s'>%s. %s</a>",$news->getId(),$date,$news->getTitle());	
		}
		
		//Выводим буфер
		return new Response($html);
    }
    /**
     * @Route("/route/news/{slug}", name="news")
     */
    public function news_show($slug)
    {
		//Находим нужную новость
        $news = $this->getDoctrine()->getRepository(News::class)->find($slug);

		//Проверяем результат поиска
		if (!$news) {
			throw $this->createNotFoundException(
				'Новость не найдена. id:'.$slug
			);
		}
		//Формируем новость и пишем в буффер
		$date = date_format ($news->getdate(),'d.m.Y');
		$html = sprintf("%s<h1>%s</h1>%s",$date,$news->getTitle(),$news->getBody());

		//Выводим буфер
		return new Response($html);
    }
}
