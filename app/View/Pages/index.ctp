<div class="row">
	<div class="col-sm-offset-1 col-sm-7 col-xs-offset-1 col-xs-10">
		<?php if ($this->Session->check('Message.flash')) : ?>
			<article class="row">
				<div class="alert alert-success">
					<?php echo $this->Session->flash(); ?>
				</div>
			</article>
		<?php endif; ?>
		<!--ここにnew topicを作る-->
		<?php if(!empty($user)): ?>
			<div class="row">
	<div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-xs-offset-1 col-xs-10">
		<h2>記事追加</h2>
		<?php echo $this->Form->create('Topic', array('class' => 'form')); ?>
<!-- 		<div class="form-group">
			<?php echo $this->Form->input('title', array('class' => 'form-control')); ?>
		</div> -->
		<div class="form-group">
			<?php echo $this->Form->input('body', array('type' => 'textarea', 'class' => 'form-control','rows' =>'3')); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->input('category_id', array('type' => 'select', 'class' => 'form-control')); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->submit('追加', array('class' => 'btn btn-success')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<?php else: ?>
<?php endif; ?>

		<?php foreach($topics as $topic): ?>
			<article class="row">
				<div class="col-sm-3">
					<h3><?php echo h($topic['Topic']['created']); ?></h3>
				</div>
				<div class="col-sm-9">
						<h2><?php echo h($topic['Topic']['title']); ?></h2>
						<?php if(!empty($user) && $topic['Topic']['user_id'] == $user['id']): ?>
							<button type="button" class="btn btn-default">
								<?php echo $this->Html->link(
									'Edit', 
									array('controller' => 'topics', 'action' => 'edit', $topic['Topic']['id'])
								); ?>
							</button>
							<button type="button" class="btn btn-default">
								<?php echo $this->Form->postLink(
									'Delete', 
									array('controller' => 'topics', 'action' => 'delete', $topic['Topic']['id']),
									array(),
									'本当に削除してもよろしいですか？'
								); ?>
							</button>
						<?php endif; ?>
						<p><?php echo $this->Text->truncate($topic['Topic']['body'],200); ?></p>
						<p><a href="/detail/<?php echo $topic['Topic']['id']?>">Continue reading</a></p>
					<span class="fa fa-tags"></span>
					<a href=""><span class="label label-danger"><?php echo $this->Html->link($topic['Category']['name'], array('controller' => 'categories', 'action' => 'view', $topic['Category']['id']));  ?></span></a>

						<p color="green"><span><?php echo $this->Html->link($topic['User']['username'], array('controller' => 'users', 'action' => 'view', $topic['User']['id']));  ?></span></p>

				</div>
			</article>
		<?php endforeach; ?>
	</div>
	<?php echo $this->element('aside'); ?>
</div>