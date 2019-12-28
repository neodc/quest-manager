<template>
	<div class="play-space" v-if="campaign !== null">
		<div class="play-list">
			<div class="play-quest-list">
				<ul>
					<li v-for="quest in campaign.quests" :class="{'active': isCurrent(quest.id, 'quest')}">
						<template v-if="!isCurrent(quest.id, 'quest') || questToEdit === null">
							<a
								:href="'#quest-' + quest.id"
								class="no-link"
							>
								{{ quest.name }}
							</a>
							<span v-if="isCurrent(quest.id, 'quest') && user.isDM" class="play-actions play-quest-actions">
								&nbsp;
								<a v-if="quest.is_visible" title="hide" @click="questToggleVisibility(quest)"><i>🚹</i></a>
								<a v-else title="show" @click="questToggleVisibility(quest)"><i>🚷</i></a>

								<a title="edit" @click="questEdit(quest)"><i>✏️</i></a>

								<a title="delete" @click="questDelete(quest)"><i class="no-color">🗑</i></a>
							</span>
						</template>
						<template v-else>
							<input v-model="questToEdit.name" style="display: inline-block; width: 5.5rem"/>
							<span v-if="isCurrent(quest.id, 'quest') && user.isDM" class="play-actions play-quest-actions">
								<a title="validate" @click="questEditConfirmed(quest)"><i>✅️</i></a>
								<a title="cancel" @click="questEditCancel"><i>❌</i></a>
							</span>
						</template>
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
			<div class="play-resource-list">
				<ul>
					<li v-for="resource in resources" :class="{'active': isCurrent(resource.id, 'resource')}">
						<a
							:href="'#resource-' + resource.id"
							class="no-link"
						>
							{{ resource.name }}
						</a>
					</li>
				</ul>
				<div class="text-center">
					<label
						for="modal-add-resource"
						v-if="user.isDM"
						class="paper-btn btn-small"
					>
						<i>➕</i>
					</label>
				</div>
				<input class="modal-state" id="modal-add-resource" type="checkbox" v-model="showAddResource">
				<div class="modal">
					<label class="modal-bg" for="modal-add-resource"/>
					<div class="modal-body is-overlay">
						<label class="btn-close" for="modal-add-resource">X</label>
						<h4 class="modal-title">Add resource</h4>
						<form @submit.prevent="resourceAdded">
							<div class="form-group">
								<label for="add-resource-name">Name</label>
								<input
									id="add-resource-name"
									v-model="resourceToAdd.name"
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
		<resource
			v-if="currentResource !== null"
			:resource="currentResource"
			:user="user"
			:users="users"
			@edited="resourceEdited"
			@visibility-change="resourceVisibilityChange"
			@delete="resourceDelete"
		/>
    </div>
</template>

<script>
    export default {
        props: {
			broadcast_channel: {
				type: String,
				required: true,
			},
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
			url_quest_visibility: {
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
			url_resource: {
				type: String,
				required: true,
			},
			url_resource_add: {
				type: String,
				required: true,
			},
			url_resource_visibility: {
				type: String,
				required: true,
			},
        },
		data() {
			return {
				campaign: null,
				user: null,
				resources: null,
				users: null,
				current: {
					type: null,
					id: null,
				},
				showAddQuest: false,
				showAddResource: false,
				questToAdd: {
					name: '',
				},
				resourceToAdd: {
					name: '',
				},
				questToEdit: null,
			};
		},
		computed: {
			currentQuest() {
				if (this.current.type == 'quest' && this.campaign && this.campaign.quests) {
					const quest = this.campaign.quests.find((quest) => quest.id === this.current.id);

					if( quest )
					{
						return quest;
					}
				}

				return null;
			},
			currentResource() {
				if (this.current.type == 'resource' && this.resources) {
					const resource = this.resources.find((resource) => resource.id === this.current.id);

					if( resource )
					{
						return resource;
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
				this.users = data.users;
			},
			setCurrentByHash() {
				const hash = location.hash.slice(1).split('-');

				if( hash.length >= 2 )
				{
					this.current.type = hash[0];
					this.current.id = parseInt(hash[1]);
					this.questToEdit = null;
				}
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
			questToggleVisibility(quest) {
				axios
					.put(
						this.url_quest_visibility.replace(':quest', quest.id),
						{
							is_visible: !quest.is_visible,
						}
					)
					.then(this.load);
			},
        	questEdit(quest) {
				this.questToEdit = _.cloneDeep(quest);
			},
        	questEditConfirmed(quest) {
				axios
					.post(
						this.url_quest.replace(':quest', quest.id),
						this.questToEdit
					)
					.then(this.load);

				this.questToEdit = null;
			},
        	questEditCancel() {
				this.questToEdit = null;
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
			resourceAdded() {
				axios
					.post(
						this.url_resource_add,
						{
							name: this.resourceToAdd.name,
							campaign_id: this.campaign.id,
						}
					)
					.then(this.load);

				this.showAddResource = false;
			},
			resourceEdited(resource) {
				axios
					.post(
						this.url_resource.replace(':resource', resource.id),
						{
							name: resource.name,
							player_description: resource.player_description,
							dm_description: resource.dm_description,
							command_by: resource.command_by,
						}
					)
					.then(this.load);
			},
			resourceVisibilityChange(resource) {
				axios
					.put(
						this.url_resource_visibility.replace(':resource', resource.id),
						{
							is_visible: resource.is_visible,
						}
					)
					.then(this.load);
			},
			resourceDelete(resource) {
				axios
					.delete(this.url_resource.replace(':resource', resource.id))
					.then(this.load);
			},
			isCurrent(id, type) {
        		return this.current.id === id && this.current.type === type;
			}
		},
		created() {
			this.load();
			let self = this;

			Echo.private(this.broadcast_channel)
				.listen(
					'CampaignUpdated',
					function (e) {
						self.campaign = e.campaign;
						self.resources = e.resources;
					}
				);

			window.addEventListener('hashchange', this.setCurrentByHash);
			this.setCurrentByHash();
		}
	}
</script>
