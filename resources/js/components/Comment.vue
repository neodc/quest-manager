<template>
	<div class="play-comment" :class="'type-' + comment.type">
		<h5>
			<template v-if="editing">
				<template v-if="comment.type === 'message'">
					<label :for="'talk-as-' + comment.id">Talk as:</label>
					<select v-model="editedComment.resource_id" :id="'talk-as-' + comment.id" class="is-inline">
						<option :value="null">---</option>
						<option v-for="resource in resources" :value="resource.id">{{ resource.name }}</option>
					</select>
				</template>
				<textarea v-else v-model="editedComment.player_text" class="is-fullwidth"></textarea>
			</template>
			<template v-else>{{ name }}</template>
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
				<a v-if="editing" title="validate" @click="validateEdit"><i>✅️</i></a>
				<a v-else title="edit" @click="edit"><i>✏️</i></a>

				<a v-if="editing" title="cancel" @click="cancelEdit"><i>❌</i></a>
				<a v-else title="delete" @click="remove"><i class="no-color">🗑️</i></a>
			</span>
			<br>
			<small>{{ comment.created_at }}</small>
		</h5>

		<template v-if="comment.type === 'message'">
			<textarea v-if="editing" v-model="editedComment.player_text" class="is-fullwidth"></textarea>
			<div v-else class="player-content" v-html="comment.player_text_html"></div>
			<div v-if="(comment.dm_text || editing) && user.isDM" class="dm-content">
				<hr>
				<textarea v-if="editing" v-model="editedComment.dm_text" class="is-fullwidth"></textarea>
				<div v-else v-html="comment.dm_text_html"></div>
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
			resources: {
				type: Array,
				required: true,
			},
        },
		data() {
        	return {
				hoverStep: null,
				editing: false,
				editedComment: null,
			};
		},
		computed: {
        	name()
			{
				if( this.comment.type === 'event' )
				{
					return this.comment.player_text;
				}
				if( this.comment.resource !== null )
				{
					return this.comment.resource.name;
				}
				if( this.comment.user !== null )
				{
					return this.comment.user.name;
				}

				return 'Deleted';
			},
			canEdit()
			{
				return this.user.isDM || this.user.id === this.comment.user_id;
			}
		},
		methods: {
			toggleVisibility() {
				this.$emit('visibility-change', {id: this.comment.id, is_visible: !this.comment.is_visible});
			},
			edit() {
				this.editedComment = _.cloneDeep(this.comment);
				this.editing = true;
			},
			validateEdit() {
				this.$emit('edited', this.editedComment);
				this.editing = false;
			},
			cancelEdit() {
				this.editing = false;
			},
			remove() {
				if(confirm('Are you sure you want to delete this comment?')) {
					this.$emit('delete', {id: this.comment.id})
				}
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
