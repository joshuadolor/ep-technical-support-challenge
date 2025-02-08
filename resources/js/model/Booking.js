export default class Booking {
    constructor(data) {
        this.data = data;
        this._id = data.id;
        this._startDate = data.start;
        this._endDate = data.end;
        this._notes = data.notes;
    }

    get id() {
        return this._id;
    }

    get startDate() {
        const date = new Date(this._startDate);
        date.setMinutes(date.getMinutes() + date.getTimezoneOffset());
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
    }

    get endDate() {
        const date = new Date(this._endDate);
        date.setMinutes(date.getMinutes() + date.getTimezoneOffset());
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
    }

    get notes() {
        return this._notes;
    }
}
