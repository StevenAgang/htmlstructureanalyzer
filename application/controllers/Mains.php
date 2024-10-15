<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mains extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
    public function __construct() {
        parent::__construct();
        $this->output->enable_profiler(false);
    }
	public function index()
	{
		$view_data = $this->base_data();
		$this->load->view('mains/index.php', $view_data);
	}
	public function base_data(): array{
		$view_data['csrf'] = array('name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash()); 
		return $view_data;
	}
	public function analyzer(): void{
		// header("Access-Control-Allow-Origin: *");
		// header("Access-Control-Allow-Methods: GET, POST");
		// header("Access-Control-Allow-Headers: Content-Type, Authorization");
		$url = $this->input->get('url',true);
		$header = [
			'Content-Type: application/json'
		];
		$curl = curl_init($url);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
		if($this->input->get('verification')){
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		}else{
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, TRUE);
		}
		curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,30);

		$response = curl_exec($curl);
		if(curl_errno($curl)){
			$view_data = array(
				'status' => false,
				'error' => curl_errno($curl)
			);
		}
		curl_close($curl);
		if($response == false){
			$view_data = array(
				'status' => false,
				'error' => 'SSL verification failed, try to disable SSL verification'
			);
		}else{
			$response = $this->html_parser($response);
			$view_data = array(
				'status' => true,
				'string' => $response['parse'],
				'tags' => $this->load->view('partials/tag.php',$response,true)
			);
		} 
		header('Content-Type: application/json');
		echo json_encode($view_data);
	
	}
	public function html_parser($response): array{
		$html = htmlspecialchars($response, ENT_HTML5);
		$matches = array();
		$dom = new DOMDocument();
		@$dom->loadHTML($response);
		$pattern = array(
			'html','meta','head','title','link','script','body','header','nav','main','section','div','article','aside','p','button',
			'form','input','canvass','caption','cite','code','a','abbr','address','area','audio','b','base','bdi','bdo','blockqoute',
			'br','col','colgroup','data','datalist','dd','del','details','dfn','dialog','dl','dt','em','embed','fieldset','figcaption',
			'figure','footer','h1','h2','h3','h4','h5','h6','hgroup','hr','i','iframe','img','ins','kbd','label','legend','li',
			'map','mark','menu','meter','noscript','object','ol','optgroup','options','output','param','picture','pre','progress','q',
			'rp','rt','ruby','s','samp','search','select','small','source','span','strong','style','sub','summary','sup','svg','table',
			'tbody','td','template','textarea','tfoot','th','thead','time','tr','track','u','ul','var','video','wbr'
		);
		foreach($pattern as $match){
			if($dom->getElementsByTagName($match)->length > 0){
				array_push($matches,array('tags' => $match, 'count' => $dom->getElementsByTagName($match)->length));
			}
		}
		$view_data = array(
			'parse' => $html,
			'count' => $matches
		);
		return $view_data;
	}
}
