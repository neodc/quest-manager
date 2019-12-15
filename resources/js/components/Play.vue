<template>
	<div class="play-space" v-if="campaign !== null">
		<div class="play-quest-list">
			<ul>
				<li v-for="quest in campaign.quests" :class="{'active': quest.id === currentQuestId}">
					<a
						:href="'#' + quest.id"
						@click="currentQuestId = quest.id"
					>
						{{ quest.name }}
					</a>
					<a v-if="quest.id === currentQuestId" title="delete" @click="questDelete(quest)">
						<i class="no-color">🗑️</i>
					</a>
				</li>
			</ul>
			<div class="text-center">
				<label
					for="modal-add-quest"
					v-if="user.isDM"
					class="paper-btn btn-small"
				>
					<i>➕</i>
				</label>
			</div>
			<input class="modal-state" id="modal-add-quest" type="checkbox" v-model="showAddQuest">
			<div class="modal">
				<label class="modal-bg" for="modal-add-quest"/>
				<div class="modal-body is-overlay">
					<label class="btn-close" for="modal-add-quest">X</label>
					<h4 class="modal-title">Add comment</h4>
					<form @submit.prevent="questAdded">
						<div class="form-group">
							<label for="add-quest-name">Name</label>
							<input
								id="add-quest-name"
								v-model="questToAdd.name"
								class="is-fullwidth"
								required
							/>
						</div>
						<div class="text-center">
							<input type="submit" value="Add" class="is-inline">
						</div>
					</form>
				</div>
			</div>
		</div>
		<quest
			v-if="currentQuest !== null"
			:quest="currentQuest"
			:user="user"
			:resources="resources"
			@step-added="stepAdded"
			@step-edited="stepEdited"
			@step-visibility-change="stepVisibilityChange"
			@step-state-change="stepStateChange"
			@step-delete="stepDelete"
			@comment-added="commentAdded"
			@comment-edited="commentEdited"
			@comment-visibility-change="commentVisibilityChange"
			@comment-delete="commentDelete"
		/>
    </div>
</template>

<script>
    export default {
        props: {
			url_update: {
				type: String,
				required: true,
			},
			url_quest_add: {
				type: String,
				required: true,
			},
			url_quest: {
				type: String,
				required: true,
			},
			url_step: {
				type: String,
				required: true,
			},
			url_step_add: {
				type: String,
				required: true,
			},
			url_step_visibility: {
				type: String,
				required: true,
			},
			url_step_state: {
				type: String,
				required: true,
			},
			url_comment: {
				type: String,
				required: true,
			},
			url_comment_add: {
				type: String,
				required: true,
			},
			url_comment_visibility: {
				type: String,
				required: true,
			},
        },
		data() {
        	return {
				campaign: null,
				user: null,
				resources: null,
				currentQuestId: parseInt(location.hash.slice(1)),
				showAddQuest: false,
				questToAdd: {
					name: '',
				},
			};
		},
		computed: {
			currentQuest() {
				if (this.campaign && this.campaign.quests) {
					const quest = this.campaign.quests.find((quest) => quest.id === this.currentQuestId);

					if( quest )
					{
						return quest;
					}
				}

				return null;
			},
		},
		methods: {
        	async load() {
        		// TODO add loader
				// TODO add error catch
				const data = (await axios.get(this.url_update)).data;

				this.campaign = data.campaign;
				this.user = data.user;
				this.resources = data.resources;
			},
        	questAdded() {
				axios
					.post(
						this.url_quest_add,
						{
							name: this.questToAdd.name,
							campaign_id: this.campaign.id,
						}
					)
					.then(this.load);

				this.showAddQuest = false;
			},
        	questDelete(quest) {
				if(!confirm('Are you sure you want to delete the quest "' + quest.name + '" and all it\'s content?')) {
					return;
				}

				axios
					.delete(this.url_quest.replace(':quest', quest.id))
					.then(this.load);

				this.showAddQuest = false;
			},
			stepAdded(step) {
				axios
					.post(this.url_step_add, step)
					.then(this.load);
			},
			stepEdited(step) {
				axios
					.post(
						this.url_step.replace(':step', step.id),
						{
							name: step.name,
							player_content: step.player_content,
							dm_content: step.dm_content,
						}
					)
					.then(this.load);
			},
			stepVisibilityChange(step) {
				axios
					.put(
						this.url_step_visibility.replace(':step', step.id),
						{
							is_visible: step.is_visible,
						}
					)
					.then(this.load);
			},
			stepStateChange(step) {
				axios
					.put(
						this.url_step_state.replace(':step', step.id),
						{
							state: step.state,
						}
					)
					.then(this.load);
			},
			stepDelete(step) {
				axios
					.delete(this.url_step.replace(':step', step.id))
					.then(this.load);
			},
			commentAdded(comment) {
				axios
					.post(this.url_comment_add, comment)
					.then(this.load);
			},
			commentEdited(comment) {
				axios
					.post(
						this.url_comment.replace(':comment', comment.id),
						{
							resource_id: comment.resource_id,
							player_text: comment.player_text,
							dm_text: comment.dm_text,
						}
					)
					.then(this.load);
			},
			commentVisibilityChange(comment) {
				axios
					.put(
						this.url_comment_visibility.replace(':comment', comment.id),
						{
							is_visible: comment.is_visible,
						}
					)
					.then(this.load);
			},
			commentDelete(comment) {
				axios
					.delete(this.url_comment.replace(':comment', comment.id))
					.then(this.load);
			},
		},
		created() {
			this.load();
		}
	}
</script>
