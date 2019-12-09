<template>
	<div class="play-comment" :class="'type-' + comment.type">
		<h5>
			{{ name }}
			<span class="play-step-actions-player">
				<a v-if="comment.step_id !== null" @mouseover="showStep" @mouseleave="hoverStep = null">
					<i>⤴️</i>
				</a>

				<template v-if="this.user.isDM">
					<a v-if="comment.is_visible" title="hide" @click="toggleVisibility"><i>🚹</i></a>
					<a v-else title="show" @click="toggleVisibility"><i>🚷</i></a>
				</template>
			</span>
			<span v-if="canEdit" class="play-step-actions-dm">
				<a title="edit" @click="edit"><i>✏️</i></a>
				<a title="delete" @click="remove"><i>❌</i></a>
			</span>
			<br>
			<small>{{ comment.created_at }}</small>
		</h5>

		<template v-if="comment.type === 'message'">
			<div class="player-content" v-html="comment.player_text"></div>
			<div v-if="comment.dm_text && user.isDM" class="dm-content">
				<hr>
				<div v-html="comment.dm_text"></div>
			</div>
		</template>
		<div
			ref="step_wrap"
			class="play-comment-step"
			:style="{display: hoverStep ? 'block' : 'none', top: hoverStep ? hoverStep.clientY + 'px' : null, left: hoverStep ? hoverStep.clientX - 400 + 'px' : null}"
		></div>
	</div>
</template>

<script>
    export default {
        props: {
			comment: {
				type: Object,
				required: true,
			},
			user: {
				type: Object,
				required: true,
			},
        },
		data() {
        	return {
				hoverStep: null,
			};
		},
		computed: {
        	name()
			{
				if( this.comment.resource !== null )
				{
					return this.comment.resource.name;
				}
				if( this.comment.user !== null )
				{
					return this.comment.user.name;
				}
				if( this.comment.type === 'message' )
				{
					return 'Deleted';
				}

				return this.comment.player_text;
			},
			canEdit()
			{
				return this.user.isDM || this.user.id === this.comment.user_id;
			}
		},
		methods: {
			toggleVisibility() {
				// TODO
			},
			edit() {
				// TODO
			},
			remove() {
				// TODO
			},
			showStep(e) {
				let step = this.$parent.$refs.steps.find((step) => step.step.id === this.comment.step_id);

				if( !step )
				{
					return;
				}

				let stepWrap = this.$refs.step_wrap;

				while (stepWrap.firstChild) {
					stepWrap.removeChild(stepWrap.firstChild);
				}

				stepWrap.append(step.$el.cloneNode(true));

				this.hoverStep = e;
			}
		},
		mounted() {
			let step = this.$parent.$refs.steps.find((step) => step.step.id === this.comment.step_id);

			if( !step )
			{
				return;
			}

			this.$refs.step_wrap.append(step.$el.cloneNode(true));
		}
	}
</script>
