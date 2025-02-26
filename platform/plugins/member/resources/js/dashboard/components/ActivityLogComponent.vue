<template>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                {{ __('activity_logs') }}
            </h4>
        </div>
        <div class="card-body" style="min-height: 15rem" v-if="loading">
            <div class="loading-spinner"></div>
        </div>

        <template v-else>
            <div class="empty" v-if="(!activityLogs?.meta || activityLogs?.meta?.total === 0)">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                        <path d="M12 9v4"></path>
                        <path d="M12 16v.01"></path>
                    </svg>
                </div>
                <p class="empty-title">
                    {{ __('oops') }}
                </p>
                <p class="empty-subtitle text-muted">
                    {{ __('no_activity_logs') }}
                </p>
            </div>

            <div v-if="activityLogs?.meta?.total !== 0" class="list-group list-group-flush">
                <div v-for="activityLog in activityLogs.data" :key="activityLog.id" class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="icon ti ti-clock"></i>
                        </div>
                        <div class="col text-truncate">
                            <div class="text-reset d-block">
                                <span
                                    :title="$sanitize(activityLog.description, { allowedTags: [] })" v-html="$sanitize(activityLog.description)"
                                ></span>
                                <a :href="'https://whatismyipaddress.com/ip/' + activityLog.ip_address" target="_blank" :title="activityLog.ip_address">
                                    ({{ activityLog.ip_address }})
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="activityLogs?.links?.next" class="card-footer">
                <a href="javascript:void(0)" v-if="!loading" @click="getActivityLogs(activityLogs.links.next)">
                    {{ __('load_more') }}
                </a>

                <a href="javascript:void(0)" v-if="loading">{{ __('loading_more') }}</a>
            </div>
        </template>
    </div>
</template>

<script>
import { HalfCircleSpinner } from 'epic-spinners'

export default {
    components: {
        HalfCircleSpinner,
    },

    data() {
        return {
            loading: false,
            activityLogs: [],
        }
    },

    mounted() {
        this.getActivityLogs()
    },

    methods: {
        getActivityLogs(url = null) {
            this.loading = true

            axios.get(url ? url : '/ajax/members/activity-logs').then((res) => {
                let oldData = []
                if (this.activityLogs.data) {
                    oldData = this.activityLogs.data
                }
                this.activityLogs = res.data
                if (this.activityLogs.length) {
                    this.activityLogs.data = oldData.concat(this.activityLogs.data)
                }

                this.loading = false
            })
        },
    },
}
</script>
