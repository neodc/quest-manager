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
				</li>
			</ul>
			<a
				v-if="user.isDM"
				class="paper-btn btn-small btn-block text-center"
				@click="addQuest"
			>
				Add more
			</a>
		</div>
		<quest
			v-if="currentQuest !== null"
			:quest="currentQuest"
			:user="user"
			:resources="resources"
			@step-edited="stepEdited"
			@step-visibility-change="stepVisibilityChange"
			@step-state-change="stepStateChange"
			@step-delete="stepDelete"
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
			url_step: {
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
        	addQuest() {
        		// TODO
			},
			async stepEdited(step) {
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
			async stepVisibilityChange(step) {
				axios
					.put(
						this.url_step_visibility.replace(':step', step.id),
						{
							is_visible: step.is_visible,
						}
					)
					.then(this.load);
			},
			async stepStateChange(step) {
				axios
					.put(
						this.url_step_state.replace(':step', step.id),
						{
							state: step.state,
						}
					)
					.then(this.load);
			},
			async stepDelete(step) {
				axios
					.delete(this.url_step.replace(':step', step.id))
					.then(this.load);
			},
			async commentEdited(comment) {
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
			async commentVisibilityChange(comment) {
				axios
					.put(
						this.url_comment_visibility.replace(':comment', comment.id),
						{
							is_visible: comment.is_visible,
						}
					)
					.then(this.load);
			},
			async commentDelete(comment) {
				axios
					.delete(this.url_edit_comment.replace(':comment', comment.id))
					.then(this.load);
			},
		},
		created() {
			this.load();
		}
	}
</script>
