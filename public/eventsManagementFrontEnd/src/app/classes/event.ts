import { Category } from './category';

export class Event {
    public id: number;
    public name: string;
    public description: string;
    public category: Category;
    public date: string;

    constructor() {
        this.category = new Category();
    }
}
