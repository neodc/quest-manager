<template>
	<div class="play-quest">
		<div class="play-step-list">
			<step v-for="step in quest.steps" :step="step" :user="user" :key="step.id" ref="steps"/>

			<p v-if="user.isDM" class="play-step-add">
				<a class="paper-btn btn-small">
					<i>➕</i>
				</a>
			</p>
		</div>
		<div class="play-comment-list">
			<comment v-for="comment in quest.comments" :comment="comment" :user="user" :key="comment.id"/>

			<p class="play-comment-add">
				<a class="paper-btn btn-small">
					<i>➕</i>
				</a>
			</p>
		</div>
	</div>
</template>

<script>
    export default {
        props: {
			quest: {
				type: Object,
				required: true,
			},
			user: {
				type: Object,
				required: true,
			},
        },
		data() {
        	return {};
		},
	}
</script>
