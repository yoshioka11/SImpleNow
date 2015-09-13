<!-- 配列の?番目のuser中のusernameをとってきている↓なんでもいいので配列の番号はなんでもいい -->
<h3>user:<?php echo($topics[0]['User']['username']); ?>さんの一言</h3>
<hr>

<div class="related">
<!-- ここも同じでuserの配列の?番目の中にtopicがなければ何も表示しないあればforeachを実行 -->
	<?php if (!empty($topics[0]['Topic'])): ?>
	<?php foreach ($topics as $topic): ?>
	
	<h3>
		<?php echo $this->Text->truncate(
			$topic['Topic']['body'],
			100); ?></h3><br>
	created:<?php echo h($topic['Topic']['created']); ?><br>
	modified:<?php echo h($topic['Topic']['modified']); ?><br>
	<h4>author:<?php echo h($topic['Topic']['user_id']); ?></h4><br>

<!-- 	<?php echo $this->Html->link(__('続きを読む'), array('controller' => 'topics', 'action' => 'view', $topic['id'])); ?> -->
	<hr>
	<?php endforeach; ?>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Topic'), array('controller' => 'topics', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
