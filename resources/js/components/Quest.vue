<template>
	<div class="play-quest">
		<div class="play-step-list">
			<step
				v-for="step in quest.steps"
				@edited="$emit('step-edited', $event)"
				@visibility-change="$emit('step-visibility-change', $event)"
				@state-change="$emit('step-state-change', $event)"
				@delete="$emit('step-delete', $event)"
				@step-comment="commentOnStep"
				:step="step"
				:user="user"
				:key="step.id"
				ref="steps"
			/>

			<p v-if="user.isDM" class="play-step-add">
				<label for="modal-add-state" class="paper-btn btn-small">
					<i>➕</i>
				</label>
			</p>
			<input class="modal-state" id="modal-add-state" type="checkbox" v-model="showAddState">
			<div class="modal">
				<label class="modal-bg" for="modal-add-state"/>
				<div class="modal-body is-overlay">
					<label class="btn-close" for="modal-add-state">X</label>
					<h4 class="modal-title">Add step</h4>
					<form @submit.prevent="addStep">
						<div class="form-group">
							<label for="add-state-name">Name</label>
							<input
								id="add-state-name"
								v-model="stepToAdd.name"
								class="is-fullwidth"
								required
								maxlength="191"
							>
						</div>
						<div class="form-group">
							<label for="add-state-player-content">Player content</label>
							<textarea
								id="add-state-player-content"
								v-model="stepToAdd.player_content"
								class="is-fullwidth"
								rows="10"
							/>
						</div>
						<div class="form-group">
							<label for="add-state-dm-content">DM content</label>
							<textarea
								id="add-state-dm-content"
								v-model="stepToAdd.dm_content"
								class="is-fullwidth"
								rows="10"
							/>
						</div>
						<div class="text-center">
							<input type="submit" value="Add" class="is-inline">
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="play-comment-list">
			<comment
				v-for="comment in quest.comments"
				@edited="$emit('comment-edited', $event)"
				@visibility-change="$emit('comment-visibility-change', $event)"
				@delete="$emit('comment-delete', $event)"
				:comment="comment"
				:user="user"
				:key="comment.id"
				:resources="resources"
			/>

			<p class="play-comment-add">
				<label for="modal-add-comment" class="paper-btn btn-small">
					<i>➕</i>
				</label>
			</p>
			<input class="modal-state" id="modal-add-comment" type="checkbox" v-model="showAddComment">
			<div class="modal">
				<label class="modal-bg" for="modal-add-comment"/>
				<div class="modal-body is-overlay">
					<label class="btn-close" for="modal-add-comment">X</label>
					<h4 class="modal-title">Add comment</h4>
					<form @submit.prevent="addComment">
						<div v-if="user.isDM" class="form-group">
							<label for="add-comment-type">Type</label>
							<select
								v-model="commentToAdd.type"
								id="add-comment-type"
								class="is-fullwidth"
							>
								<option value="message">Message</option>
								<option value="event">Event</option>
							</select>
						</div>
						<div v-if="commentToAdd.type === 'message'" class="form-group">
							<label for="add-comment-talk-as">Talk as</label>
							<select
								v-model="commentToAdd.resource_id"
								id="add-comment-talk-as"
								class="is-fullwidth"
							>
								<option :value="null">{{ user.name }}</option>
								<option v-for="resource in commandedResources" :value="resource.id">{{ resource.name }}</option>
							</select>
						</div>
						<div class="form-group">
							<label for="add-comment-player-text">Player text</label>
							<textarea
								id="add-comment-player-text"
								v-model="commentToAdd.player_text"
								class="is-fullwidth"
								rows="10"
							/>
						</div>
						<div v-if="commentToAdd.type === 'message' && user.isDM" class="form-group">
							<label for="add-comment-dm-text">DM text</label>
							<textarea
								id="add-comment-dm-text"
								v-model="commentToAdd.dm_text"
								class="is-fullwidth"
								rows="10"
							/>
						</div>
						<div class="text-center">
							<input type="submit" value="Add" class="is-inline">
						</div>
					</form>
				</div>
			</div>
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
			resources: {
				type: Array,
				required: true,
			},
        },
		data() {
        	return {
				showAddState: false,
				showAddComment: false,
				stepToAdd: {
					name: '',
					player_content: '',
					dm_content: '',
				},
				commentToAdd: {
					type: 'message',
					resource_id: null,
					player_text: '',
					dm_text: '',
					step_id: null,
				},
			};
		},
		computed: {
        	commandedResources() {
        		if(this.user.isDM) {
					return this.resources;
				}

        		const userId = this.user.id;

        		return this.resources.filter(
        			function(resource)
					{
						return resource.command_by.findIndex(user => user.id === userId) >= 0;
					}
				)
			}
		},
		methods: {
        	addStep() {
				this.$emit(
					'step-added',
					{
						name: this.stepToAdd.name,
						player_content: this.stepToAdd.player_content,
						dm_content: this.stepToAdd.dm_content,
						quest_id: this.quest.id,
					}
				);

				this.showAddState = false;

				this.stepToAdd.name = '';
				this.stepToAdd.player_content = '';
				this.stepToAdd.dm_content = '';
			},
        	addComment() {
				this.$emit(
					'comment-added',
					{
						type: this.commentToAdd.type,
						resource_id: this.commentToAdd.resource_id,
						player_text: this.commentToAdd.player_text,
						dm_text: this.commentToAdd.dm_text,
						step_id: this.commentToAdd.step_id,
						quest_id: this.quest.id,
					}
				);

				this.showAddComment = false;

				this.commentToAdd.type = 'message';
				this.commentToAdd.resource_id = null;
				this.commentToAdd.player_text = '';
				this.commentToAdd.dm_text = '';
			},
			commentOnStep(step) {
        		this.commentToAdd.step_id = step.id;
        		this.showAddComment = true;
			}
		},
		watch: {
			showAddComment(after, before) {
				if( after === false ) {
					this.commentToAdd.step_id = null;
				}
			}
		},
	}
</script>
