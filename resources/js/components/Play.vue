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
		<quest v-if="currentQuest !== null" :quest="currentQuest" :user="user"/>
    </div>
</template>

<script>
    export default {
        props: {
			url_update: {
				type: String,
				required: true,
			},
        },
		data() {
        	return {
				campaign: null,
				user: null,
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
        	addQuest() {
        		// TODO
			},
		},
		async created() {
			const data = (await axios.get(this.url_update)).data;

			this.campaign = data.campaign;
			this.user = data.user;
		}
	}
</script>
