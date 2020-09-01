<?php
abstract class NewsManager
{
	/*
	*Méthode permettant d'ajouter une news.
	*@param $news News La news à ajouter
	*@return void
	*/
	abstract protected function add(News $news);
	
	
	/*
	Méthode renvoyant le nombre de news total
	@return int
	*/
	abstract public function count();
	
	
	/*
	Méthode permettent de supprimer une news
	@pram $id int l'identifiant de la news à supprimer
	@return void
	*/
	abstract public function delete($id);
	
	
	/*
	Méthode retournant une liste de news demandée.
	@param $debut int la premiere news selectionner
	@param $limite le nombre de news à selectionner
	@return array la liste de news. Caque entrée est une instance de next
	*/
	abstract public function getList($debut = -1, $limite = -1);
	
	
	/*
	Méthode retournent une news précise
	@param $id int identifiant de la news à récupérer
	@return News la news demandée
	*/
	abstract public function getUnique($id);
	
	
	/*
	Méthode permettant d'enregistrer une news
	@param $news News la news à enregistrer
	@see self::add()
	@see self::modify()
	@return void
	*/
	public function save(News $news)
	{
		if($news->isValid())
		{
			$news->isNew() ? $this->add($news) : $this->update($news);
		}
		else
		{
			throw new RuntimeException('La news doit être validé pour être enregistrée');
		}
	}
	
	
	/*
	Méthode permettant d emodifier une news
	@param $news news la news à modifier
	@return void
	*/
	abstract protected function update(News $news);
	
}