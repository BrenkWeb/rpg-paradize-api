<?php 
	/*
		RPG-Paradize API	
			Propulsé par Brenk / brenk@outlook.fr
			https://github.com/BrenkWeb
	*/

	class RPGParadize_API
	{
		public function __construct($i, $s = false)
		{
			if($s) {
				if(isset($_SESSION['rpa-cache'])) {
					if(time() - $_SESSION['rpa-cache']['time'] > 3600) {
						$this->src = $this->get_rpg($i);
					} else {
						$this->src = $_SESSION['rpa-cache']['src'];
					}
				} else {
					$this->src = $this->get_rpg($i);
					$_SESSION['rpa-cache']['time'] = time();
					$_SESSION['rpa-cache']['src'] = $this->src;
				}
			} else {
				$this->src = $this->get_rpg($i);
			}
			$this->vote = $this->get('vote');
			$this->position = $this->get('position');
			$this->clic	= $this->get('clic-out');
			$this->history = $this->get('history-vote');
			$this->comments = $this->get('comments');
		}
		
		private function get_rpg ($i) 
		{
			return file_get_contents('http://www.rpg-paradize.com/info_site-'.$i);
		}
		private function get ($v) 
		{
			switch($v)
			{
				case 'comments':
					$c = explode('<hr class="hrtitle" />', $this->src);
					return explode('<br>', $c[3])[0];
				case 'clic-out':
					$c = explode('Clic Sortant : ', $this->src);
					return explode('</td>', $c[1])[0];
				case 'vote':
					$v = explode('Vote : ', $this->src);
					return explode('</a>', $v[1])[0];
				case 'position':
					$p = explode('Position ', $this->src);
					return explode('</b>', $p[1])[0];
				case 'history-vote':
					$this->src = str_replace('/jslib/Chart.js', 'http://www.rpg-paradize.com/jslib/Chart.js', $this->src);
					$h = explode('<hr class="hrtitle" />', $this->src);
					return explode('<br>', $h[2])[0];
			}
		}
		public function comments ($w) 
		{
			return str_replace('715', $w, $this->comments);
		}
		public function history ($w, $h) 
		{
			$n = str_replace('height:140px', 'height:'.$h, $this->history);
			$w = str_replace('width:100%', 'width:'.$w, $n);
			return $w;
		}
	}
