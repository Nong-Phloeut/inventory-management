import { defineStore } from 'pinia'
import dashboardService from '../api/dashboard'

export const useDashboardStore = defineStore('dashboard', {
  state: () => ({
    stats: null,
    loading: false
  }),
  actions: {
    async fetchStats() {
      this.loading = true
      const res = await dashboardService.getStats()
      this.stats = res.data
      this.loading = false
    }
  }
})
