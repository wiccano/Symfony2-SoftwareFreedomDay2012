<?php

namespace Admin\DashboardBundle\Components;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Admin\DashboardBundle\Form\Components\DatagridFormType;

class Toxty_Datagrid
{
	protected $container;
		
	private $id;
	private $headers;
	private $data;
	private $filters;
	private $withform;
	private $formname;	
	private $primarykey;
	private $urlpost;
	private $tamano;
	private $gridcount;
	private $contentheader;
			
	private $numerable;	
	private $functnumerable;	
	
	private $paginable;		
	private $page;
	private $pagecount;
	private $perpage;
	private $tamanoperpage;
	private $paginablefooter;
	private $countheader;
	
	private $sortable;
	private $orderby;
	private $orderdirection;
	private $delete;
	private $urldelete;
 	
	public function __construct(ContainerInterface $container, array $options = NULL)
    {
    	$this->container = $container;

		if(isset($options['id'])){
			$this->id = $options['id'];			
		}else{
			throw new \Exception('parametro [id] es obligatorio en array opciones para generar Toxty_DataGrid');
		}
		
		// Default page = 1
    	$this->page = 1;
		if(isset($options['page'])) {
			 $this->page = $options['page']; 
		}
		
		// Default tamano = 10
    	$this->tamano = 10;
		if(isset($options['tamano'])){
			$this->tamano = $options['tamano'];
		}
		
		// Default tamanoperpage = ''
		if(isset($options['tamanoperpage'])){
			$this->tamanoperpage = $options['tamanoperpage'];
		}
		
		if(isset($options['tamano']) && !isset($options['tamanoperpage'])){
			$this->tamanoperpage = $options['tamano'];
		}
		
		if(isset($options['tamano']) && isset($options['tamanoperpage']) && $options['tamano'] && !$options['tamanoperpage']){
			$this->tamanoperpage = $options['tamano'];
		}
				
		// Default orderby = ''
    	$this->orderby = '';
		if(isset($options['orderby'])){
			$this->orderby = $options['orderby'];
		}
		
		// Default sortable = true
    	$this->orderdirection = 'ASC';
		if(isset($options['orderdirection'])){
			$this->orderdirection = $options['orderdirection']; 
		}
		
		// Default filters = array();
    	$this->filters = array();
		if(isset($options['filters'])){
			if(is_array($options['filters']))
			{
				$this->filters = $options['filters']; 
			}else{
				throw new \Exception('parametro [filters] debe ser un array para generar Toxty_DataGrid');
			}
		}
								
		// Default withform = true 
		$this->withform = true;
		
		// Default formname = Form _ $this->id
		$this->formname = "Form_".$this->id;
			
		// Default numerable = false
    	$this->numerable = false;	
		
		// Default functnumerable = array()
    	$this->functnumerable = array();
					
    	// Default paginable = true
    	$this->paginable = true;
		
		// Default paginablefooter = false
    	$this->paginablefooter = false;
		
		// Default paginablefooter = false
    	$this->countheader = true;
				
		// Default perpage = array(10 => '10'10 => '10', 20 => '20', 50 => '50', 100 => '100')
		$this->perpage = array(10 => '10', 20 => '20', 50 => '50', 100 => '100');
			
		// Default sortable = true
    	$this->sortable = true;
				
		// Default delete = true
    	$this->delete = false;
	}
	
	/* id */
	public function getId()
	{
        return $this->id;
    }
	
	/* WithForm */
	public function setWithForm($withform)
	{
        $this->withform = $withform;
    }
	
	public function getWithForm()
	{
        return $this->withform;
    }
	
	/* FormName */
	public function setFormName($formname)
	{
        $this->formname = $formname;
    }
	
	public function getFormName()
	{
        return $this->formname;
    }
	
	/* Headers */
	public function setHeaders(array $headers)
	{
        $this->headers = $headers;
    }
	
	public function getHeaders()
	{
        return $this->headers;
    }
	
	/* Data */
	public function setData(array $data)
    {
        $this->data = $data;
    }
	
	public function getData()
    {
        return $this->data;
    }
	
	/* Filters */
	public function setFilters($filters)
    {	
		$this->filters = $filters;	
	}
	
	public function getFilters()
    {
		return $this->filters; 
	}
	
	/* Params SQL */
	public function getParamsSql()
    {
    	$order = $this->getOrderBy() ? "{$this->getOrderBy()} {$this->getOrderDirection()}" :"";
		$arAux = array('page'=>$this->getPage(), 'size'=>$this->getTamano(), 'order'=>$order);
		return array_merge($this->getFilters(), $arAux);  
	}
	
	/* PrimaryKey 
	 * Have the primary key of data.
	 * Primary key must exist in array data.
	 * */
	public function setPrimaryKey($primarykey)
    {
        $this->primarykey = $primarykey;
    }
	
	public function getPrimaryKey()
    {
        return $this->primarykey;
    }
	
	/* URL 
	 * Have the URL of pagination or filters.
	 * */
	public function setUrl($urlpost)
    {
        $this->urlpost = $urlpost;
    }
	
	public function getUrl()
    {
        return $this->urlpost;
    }
	
	/* Numerable 
	 * If true draw countable data column
	 * */
	public function setNumerable($numerable)
    {
    	$this->numerable = $numerable;
    }
	
	public function getNumerable()
    {
        return $this->numerable;
    }
	
	/* Numerable 
	 * Event in numerable column
	 * */
	public function setFunctNumerable($functnumerable)
    {
    	$this->functnumerable = $functnumerable;
    }
	
	public function getFunctNumerable()
    {
        return $this->functnumerable;
    }
	
	
	/* Paginable */
	public function setPaginable($paginable)
    {
    	$this->paginable = $paginable;
    }
	
	public function getPaginable()
    {
        return $this->paginable;
    }
	
	/* paginablefooter */
	public function setPaginableFooter($paginablefooter)
    {
        $this->paginablefooter = $paginablefooter;
    }
	
	public function getPaginableFooter()
    {
        return $this->paginablefooter;
    }
	
	/* CountHeader */
	public function setCountHeader($countheader)
    {
        $this->countheader = $countheader;
    }
	
	public function getCountHeader()
    {
        return $this->countheader;
    }
	
			
	/* Page */
	public function setPage($page)
    {
        if($page > 0)	
        	$this->page = $page;
    }
	
	public function getPage()
    {
        return $this->page;
    }	
	
	/* PageCount 
	 * Have the total pages in the data grid.
	 * */
	public function setPageCount($pagecount)
    {
        $this->pagecount = $pagecount;
    }
	
	public function getPageCount()
    {
        return $this->pagecount;
    }
	
	/* Tamano */
	public function setTamano($tamano)
    { 	
		$this->tamano = $tamano;
    }
	
	public function getTamano()
    {
        return $this->tamano;
    }
	
	/* GridCount 
	 * Have the total items in the data grid.
	 * */
	public function setGridCount($gridcount)
    {	
        $this->gridcount = $gridcount;
	}
	
	public function getGridCount()
    {
        return $this->gridcount;
    }
	
	/* perPage */
	public function setperPage($perpage)
    {
    	$this->perpage = $perpage;
         
    }
	public function getperPage()
    {
        return $this->perpage;
    }
	
	/* Sortable */
	public function setSortable($sortable)
    {
        $this->sortable = $sortable;
    }
	
	public function getSortable()
    {
        return $this->sortable;
    }
	
	/* OrderBy */
	public function setOrderBy($orderby)
    {
        $this->orderby = $orderby;
    }
	
	public function getOrderBy()
    {
        return $this->orderby;
    }
	
	/* OrderDirection */
	public function setOrderDirection($orderdirection)
    {
        $this->orderdirection = $orderdirection;
    }
	
	public function getOrderDirection()
    {
        return $this->orderdirection;
    }
	
	/* Delete */
	public function setDelete($delete)
    {
        $this->delete = $delete;
    }
	
	public function getDelete()
    {
        return $this->delete;
    }
	
	/* UrlDelete */
	public function setUrlDelete($urldelete)
    {
        $this->urldelete = $urldelete;
    }
	
	public function getUrlDelete()
    {
        return $this->urldelete;
    }

	/* ContentHeader */
	public function setContentHeader($contentheader)
    {
        $this->contentheader = $contentheader;
    }
	
	public function getContentHeader() 
    {
        return $this->contentheader;
    }
	
	/* Show DataGrid */	
	public function renderCell($title, $valor)
	{
		return $valor[$title]; 
	}	
	
	public function renderHeaderContent()
	{
		return; 
	}	
	
	/* Evaluate datagrid and exeptions  */
	public function evaluate()
	{
		// Evaluate Form Name		
		if($this->withform === false)
		{
			if(strlen(trim($this->formname)) <= 0)
			{
				throw new \Exception('valor [formname] es obligatorio con withform = false para generar Toxty_DataGrid');	
			}				
		}
		
		// Evaluate control paginable data grid
		if($this->paginable===false)
        {
        	if((is_array($this->data) && count($this->data)!=0))
			{
				$this->tamano = count($this->data);
				$this->gridcount = count($this->data);
				$this->pagecount = ceil($this->gridcount/$this->tamano);
			}
        }
		
		if($this->paginable===true)
	  	{	
			if(!$this->urlpost){
				throw new \Exception('valor [url] es obligatorio para generar paginable Toxty_DataGrid');
			}
										
			if(!is_array($this->data) || (is_array($this->data) && count($this->data)==0))
			{
				$this->paginable = false;
				$this->paginablefooter = false;
			}
	  							
			if(!$this->pagecount){
				if($this->pagecount==0){
					$this->pagecount = 1;								
				}else{
					throw new \Exception('valor [pagecount] es indefinido para generar Toxty_DataGrid');
				}		
			}				
		
			if (is_numeric($this->tamanoperpage) && !array_key_exists($this->tamanoperpage, $this->perpage)) {
	    		$this->perpage[$this->tamanoperpage] = $this->tamanoperpage; 
				ksort($this->perpage);
			}
			
			if(!is_numeric($this->tamano)){
				throw new \Exception('valor [tamano] debe ser definido para generar Toxty_DataGrid');
			}
			
			if(!is_numeric($this->gridcount)){
				throw new \Exception('valor [gridcount] debe ser definido para generar Toxty_DataGrid');
			}
			$this->pagecount = ceil($this->gridcount/$this->tamano);
		}
		
		// Evaluate  total count items in headers
		if(!is_array($this->data) || (is_array($this->data) && count($this->data)==0))
		{
			$this->countheader = false;
		}	
		
		// Evaluate numerable and functnumerable
		if($this->numerable === true)
		{
			if($this->functnumerable && !is_array($this->functnumerable)){
				throw new \Exception('valor [functnumerable] debe ser array para generar column numerable Toxty_DataGrid');
			} 	
			
			if(is_array($this->functnumerable)){					
				$arNumerable = array('enumerable' => array('_event' => $this->functnumerable));					
				$this->headers = array_merge($arNumerable, $this->headers);
			}	
		} 
			
		return true;		
	}
	
	public function show()
    {
		if($this->evaluate())
		{
		  	$paginableForm = new DatagridFormType($this->getId());
			$options = array("id" => $this->id, "page" => $this->page, "tamanoperpage" => $this->tamanoperpage, "tamano" => $this->tamano, "orderby" => $this->orderby, "orderdirection" => $this->orderdirection);       
	        $PaginableForm = $this->container->get('form.factory')->create($paginableForm, $options); 
								
	    	$engine = $this->container->get('templating');
			$content = $engine->render('AdminDashboardBundle:Components:datagrid.html.twig', array(
				'grid' => $this,
				'form' => $PaginableForm->createView(),
			));
			return $content;
		}	
	}	  
} 