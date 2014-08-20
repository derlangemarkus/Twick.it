<?php

class Basebar {

	var $page;
	var $options;
	var $wp_query;
	var $div_name;     //name of the *bar
	var $pbOptions;
	var $max_page;
    // -------------------------------------------------------------------------
    function init($pbOptions)
		{

		}  // function init
    // -------------------------------------------------------------------------

		function add_stylesheet() {
			global $pbOptions;

			$url = "jquery.tabs.css";
			$handle = 'jquery-tabs';
			wp_register_style($handle, $url);
			wp_enqueue_style($handle);
			wp_print_styles();


			$url = "jquery.tabs.iecss";
			$handle = 'jquery-tabs.ie';
			wp_register_style($handle, $url);
			wp_enqueue_style($handle);
			wp_print_styles();


			if ($pbOptions["stylesheet"] == "styleCss")
				return;
			$url = get_bloginfo('stylesheet_directory') . '/' . $pbOptions["cssFilename"];
			$handle = 'pagebar-stylesheet';
			wp_register_style($handle, $url);
			wp_enqueue_style($handle);
			wp_print_styles();

		}
    // -------------------------------------------------------------------------
		function __construct($page, $max_page) {
				global $wp_query, $pbOptions;

				$this->div_name = "pagebar";
				$this->paged = $page;
				$this->max_page = $max_page;
				$this->wp_query = $wp_query;
				$this->pbOptions = $pbOptions;         // load options
				$this->init($this->pbOptions);                             // initialize
		}  //function __construct()


    function Basebar($page, $max_page) {
		$this->__construct($page, $max_page);
	}

    // -------------------------------------------------------------------------
    function create_link($page) {
			return get_pagenum_link($page);
    }
		// -----------------------------------------------------------------------------
		function tagReplace($text,$page) {

			$text = str_replace ( "{page}", $page, $text );
			$text = str_replace ( "{current}", $page, $text );
			$text = str_replace ( "{total}", $this->max_page, $text );

		  //if (strpos($text, '{img:') !== false)
		  //  $text = pb_insertImage($text, $page);

			return $text;
		}
	  // -------------------------------------------------------------------------
		function previousPage($paged) {

			if ($this->pbOptions ["pdisplay"] == "never")
				return;

			if (($this->paged == 1) && ($this->pbOptions ["pdisplay"] == "auto"))
				return;

			$text = $this->tagReplace($this->pbOptions ["prev"], $this->paged);
			echo ($this->paged == 1) ? '<span class="inactive">' . $text . "</span>\n" : '<a href="' .
						$this->create_link ( $this->paged - 1 ) . '"' . $this->tooltip ($this->paged - 1 ) . '>' .
						$text . "</a>\n";
		}
		// -----------------------------------------------------------------------------
		function thisPage($page) {

			echo '<span class="this-page">' . $this->tagReplace($this->replaceFirstLast ( $page ),
																											$page) . "</span>\n";
		}
		// -----------------------------------------------------------------------------
		function nextPage($page,$max_page) {
			if ($this->pbOptions ["pdisplay"] == "never")
				return;
			if (($this->paged == $max_page) && ($this->pbOptions ["ndisplay"] == "auto"))
				return;
			$text = $this->tagReplace($this->pbOptions ["next"], $page);
			echo ($this->paged == $max_page) ? '<span class="inactive">' . $text .
			      "</span>\n" : '<a href="' . $this->create_link ( $this->paged + 1 ) . '"' .
						$this->tooltip ( $this->paged + 1 ) . '>' . $text . "</a>\n";
		}
		// -----------------------------------------------------------------------------
		function transit($place) {
			if ($place > 0) echo '<span class="break">';
			echo $this->pbOptions["connect"] !== "" ? $this->pbOptions["connect"] : '...';
			echo '</span>';
		}
		// -----------------------------------------------------------------------------

		function replaceFirstLast($page) {
			switch ( $page) {
				case 1 :
					return $this->pbOptions ['first'];
				case $this->max_page :
					return $this->pbOptions ['last'];
				case $this->paged:
					return $this->pbOptions['current'];
				default :
					return $this->pbOptions['standard'];
			}
		}
		// -----------------------------------------------------------------------------
		function page($page) {
			$link = $this->create_link($page);
			echo '<a href="' . $link . '"' . $this->tooltip($page) . '>' .
			     $this->TagReplace($this->replaceFirstLast($page), $page) . "</a>\n";
		}
		// -----------------------------------------------------------------------------
		function tooltip($page) {
			if ($this->pbOptions ["tooltips"])
				return ' title="' . $this->tagReplace ( $this->pbOptions ["tooltipText"], $page ) . '"';
			return "";
		}

		// -----------------------------------------------------------------------------
		function leave() {

		if (is_singular())
		  return 1;

		if ($this->max_page <= 1) // only one page -> don't display pagebar
		  return 1;
		}//leave()
		// -----------------------------------------------------------------------------

		function div_start() {
				echo '<div class="'.$this->div_name.'">';
		}//div_start()
		// -----------------------------------------------------------------------------

		function div_end() {
				echo "</div>";
		}//div_end()

		// -----------------------------------------------------------------------------

		function display() {

				if ($this->wp_query->is_feed)    // no need for pagebar in feed
						return;

				if (is_admin())   		  		    // since WP2.5 got it's own admin pagebar
						return;

				if ($this->leave())
						return;

			  $left = $this->pbOptions ["left"];
			  $center = $this->pbOptions ["center"];
			  $right = $this->pbOptions ["right"];

				if (empty ( $this->paged )) // If we're on the first page the var $this->paged is not set.
					$this->paged = 1;

				// insert HTML comment for support reasons
				echo "<!-- pb259 -->";
				$this->div_start();

				echo $this->tagReplace ( $this->pbOptions ["pbText"], $this->paged ) . '&nbsp;';

				// it's easy to show all page numbers:
				// simply loop and  exit
				if ($this->max_page <= $left + $center + $right) {
					$this->previousPage ( $this->paged );
					for($i = 1; $i <= $this->max_page; $i ++)
						if ($i == $this->paged)
							$this->thisPage ( $i ); else
							$this->page ( $i );
					$this->nextPage ( $this->paged, $this->max_page );
					echo "</div>";
					return;
				} //if

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// left and right
	if ($this->paged < $left + $center) {
		//left
		$this->previousPage($this->paged);
		$lc = $left + $center;
		for ($i = 1;$i <= ($lc);$i++) if ($i == $this->paged) $this->thisPage($i);
		else $this->page($i);
		// right
		$this->transit($right);
		for ($i = $this->max_page - $right + 1;$i <= $this->max_page;$i++)
		  $this->page($i);
		$this->nextPage($this->paged, $this->max_page);
	}
	else
	// left, right and center
	if (($this->paged >= $left + $center) && ($this->paged < $this->max_page - $right - $center + 1)) {
		//left
		$this->previousPage($this->paged);
		for ($i = 1;$i <= $left;$i++)
		  $this->page($i);
		$this->transit($left);
		//center
		$c = floor($center / 2);
		for ($i = $this->paged - $c;$i <= $this->paged + $c;$i++)
				if ($i == $this->paged)
				  $this->thisPage($i);
				else
				  $this->page($i);
		// right
		$this->transit($right);
		for ($i = $this->max_page - $right + 1;$i <= $this->max_page;$i++)
		  $this->page($i);
		$this->nextPage($this->paged, $this->max_page);
	}
	else
	// only left and right
	{
		//left
		$this->previousPage($this->paged);
		for ($i = 1;$i <= $left;$i++) $this->page($i);
				$this->transit($left);
		// right
		for ($i = $this->max_page - $right - $center;$i <= $this->max_page;$i++)
				if ($i == $this->paged)
						$this->thisPage($i);
				else
						$this->page($i);
		$this->nextPage($this->paged, $this->max_page);
	}

  $this->div_end();

		} // function display()

} //class

?>
