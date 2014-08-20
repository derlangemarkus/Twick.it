<?php

require_once("class-basebar.php");

class Commentbar extends Basebar {

		function __construct($paged, $max_page) {
				parent::__construct($paged, $max_page);
				if (! $this->pbOptions = get_option('commentbar') ) {
					pagebar_activate();
					$this->pbOptions = get_option('commentbar');
				}
				$this->div_name = "commentbar";
				if ($this->pbOptions['inherit']) {
				    $tmp_pbOptions = get_option('postbar');
				    foreach ($tmp_pbOptions as $key=>$val )
                if (isset($this->pbOptions[$key]))
					  $this->pbOptions[$key] = $tmp_pbOptions[$key];
                                    $this->div_name = "pagebar";
				}

				$this->display();
		} //__construct()


		function Commentbar($paged, $max_page) {
				$this->__construct($paged, $max_page);

		}
		// -----------------------------------------------------------------------------
    function leave() {
				// TODO: leave parameters
				if (get_query_var('all')) // all parts displayed
				  return 1;
				if ($this->max_page <= 1)
				  return 1;
				return 0;
		} //leave()


		// -----------------------------------------------------------------------------
		function create_link($page) {
				return clean_url( get_comments_pagenum_link( $page, $this->max_page ) );
		} //create_link()

		// -----------------------------------------------------------------------------
		function display() {
				parent::display();
		} //display()

		// -----------------------------------------------------------------------------
  		function div_end() {
				/*if ($this->pbOptions['all'])
			  	  echo $this->allPagesLink();
				*/echo "</div>";
		}//div_end()
		// -----------------------------------------------------------------------------
		function allPagesLink() {
		global $post;
				if ( '' == get_option('permalink_structure') || 'draft' == $post->post_status ) {
						$page_link_type = '&amp;page=';
						$page_link_all = '&amp;all=1';
				} //if
				else {
						$page_link_type = '/';
						$page_link_all = '/all/1';
						$url = get_permalink();
						if ( '/' == $url[strlen($url)-1])
								$slash_yes = '/';
				} //else

			return '<a href="'. untrailingslashit(get_permalink()) .
							$page_link_all . '">' . $this->pbOptions['label_all'] . '</a></li>';

		} //allPagesLink()


} // class Commentbar

?>