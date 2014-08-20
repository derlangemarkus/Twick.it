<?php
require_once("class-basebar.php");

class Multipagebar extends Basebar {

		function __construct($paged, $max_page) {
		    parent::__construct($paged, $max_page);
                    $this->div_name = "multipagebar";
                    if (! $this->pbOptions = get_option('multipagebar')) {
                        pagebar_activate();
                        $this->pbOptions = get_option('multipagebar');
                    }
                    if ($this->pbOptions['inherit']) {
                        $tmp_pbOptions = get_option('postbar');
			foreach ($tmp_pbOptions as $key=>$val )
                            if (isset($this->pbOptions[$key]))
                                $this->pbOptions[$key] = $tmp_pbOptions[$key];
                            $this->div_name = "pagebar";
		    }
		    echo parent::display();

		}  // function __construct()


		function Multipagbar($paged, $max_page) {
				$this->__construct($paged, $max_page);

		}
 		// -------------------------------------------------------------------------

		function leave() {
				if ($this->max_page <= 1) // only one page
						return 1;
	      if (get_query_var('all')) // all parts displayed
				  return 1;
				return 0;
		}

 		// -------------------------------------------------------------------------
		function create_link($page) {
				global $post;
				if ($page == 1) {
					$link = get_permalink();
				}
				else {
					if ('' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')))
						$link = get_permalink() . '&amp;page=' . $page;
					else
						$link = trailingslashit(get_permalink()) . user_trailingslashit($page, 'single_paged');
				} //else

			return $link;
		} //create_link()

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
		// -----------------------------------------------------------------------------
		function div_end() {
				if ($this->pbOptions['all'])
						echo $this->allPagesLink();
				echo "</div>";
		}//div_end()
		// -----------------------------------------------------------------------------


} // class Multipagebar
?>