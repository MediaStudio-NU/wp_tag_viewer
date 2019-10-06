<?php
/*
Plugin Name: Tag Viewer
Description: タグ一覧を表示
Author: Y.Nagata
Version: 0.0.0
*/

class TagViewer {
	function __construct() {
		add_action('admin_menu', array($this, 'add_pages'));
	}
	function add_pages() {
		add_menu_page(__('Tag'), __('Tag'), 'read', 'tag_viewer', array($this,'tag_viewer_page'),"dashicons-tag", 6);
	}
	function tag_viewer_page() {
		$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'name';
		$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
		?>
			<div class="wrap">
				<h1 class="wp-heading-inline"><?php print __('Tag') ?></h1>
				<table class="wp-list-table widefat fixed striped tags">
					<thead>
						<tr>
							<th scope="col" id="name" class="manage-column column-name column-primary sort<?php print ($orderby == 'name') ? 'ed '.$order : 'able desc' ?>">
								<a href="/wp-admin/admin.php?page=tag_viewer&orderby=name&order=<?php print ($orderby == 'name' && $order == 'asc') ? 'desc' : 'asc' ?>">
									<span><?php print __('Name') ?></span>
									<span class="sorting-indicator"></span>
								</a>
							</th>
							<th scope="col" id="description" class="manage-column column-description sort<?php print ($orderby == 'description') ? 'ed '.$order : 'able desc' ?>">
								<a href="/wp-admin/admin.php?page=tag_viewer&orderby=description&order=<?php print ($orderby == 'description' && $order == 'asc') ? 'desc' : 'asc' ?>">
									<span><?php print __('Description') ?></span>
									<span class="sorting-indicator"></span>
								</a>
							</th>
							<th scope="col" id="slug" class="manage-column column-slug sort<?php print ($orderby == 'slug') ? 'ed '.$order : 'able desc' ?>">
								<a href="/wp-admin/admin.php?page=tag_viewer&orderby=slug&order=<?php print ($orderby == 'slug' && $order == 'asc') ? 'desc' : 'asc' ?>">
									<span><?php print __('Slug') ?></span>
									<span class="sorting-indicator"></span>
								</a>
							</th>
							<th scope="col" id="posts" class="manage-column column-posts num sort<?php print ($orderby == 'posts') ? 'ed '.$order : 'able desc' ?>">
								<a href="/wp-admin/admin.php?page=tag_viewer&orderby=count&order=<?php print ($orderby == 'count' && $order == 'asc') ? 'desc' : 'asc' ?>">
									<span><?php print _x( 'Count', 'Number/count of items' ) ?></span>
									<span class="sorting-indicator"></span>
								</a>
							</th>
						</tr>
					</thead>
					<tbody id="the-list" data-wp-lists="list:tag">
					<?php
						$args = array(
							'orderby' => $orderby,
							'order' => $order,
							'hide_empty' => false
						);
						$posttags = get_tags( $args );

						if ( $posttags ){
							foreach( $posttags as $tag ) {
								?>
									<tr id="tag-<?php echo $tag->term_id; ?>" class="level-0">
										<td class="name column-name has-row-actions column-primary" data-colname="<?php print __('Name') ?>">
											<strong><?php echo $tag->name; ?></strong>
											<br>
											<div class="hidden" id="inline_<?php echo $tag->term_id; ?>">
												<div class="name"><?php echo $tag->name; ?></div>
												<div class="slug"><?php echo $tag->slug; ?></div>
												<div class="parent"><?php echo $tag->parent; ?></div>
											</div>
											<button type="button" class="toggle-row">
												<span class="screen-reader-text"><?php print __('Show more details') ?></span>
											</button>
										</td>
										<td class="description column-description" data-colname="<?php print __('Description') ?>">
											<p><?php echo $tag->description; ?></p>
										</td>
										<td class="slug column-slug" data-colname="<?php print __('Slug') ?>"><?php echo $tag->slug; ?></td>
										<td class="posts column-posts" data-colname="<?php print _x( 'Count', 'Number/count of items' ) ?>"><?php echo $tag->count; ?></td>
									</tr>	
								<?php
							}
						}
					?>
					</tbody>
				</table>
			</div>
		<?php
    }
}
$tag_viewer = new TagViewer; 
