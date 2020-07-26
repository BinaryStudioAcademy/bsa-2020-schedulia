import requestService from '../requestService';

const requestService = {
	getStatus() {
		return requestService.getStatus('/api/status');
	}
};
