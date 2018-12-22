import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { EventService } from 'src/app/services/event.service';
import { Event } from 'src/app/classes/event';
import { CategoryService } from 'src/app/services/category.service';
import { Category } from 'src/app/classes/category';


@Component({
  selector: 'app-update-event',
  templateUrl: './update-event.component.html',
  styleUrls: ['./update-event.component.css']
})
export class UpdateEventComponent implements OnInit {
  event: Event;
  categories: Category[];

  constructor(private route: ActivatedRoute,
              private eventService: EventService,
              private router: Router,
              private categoryService: CategoryService) { }

  ngOnInit() {
    this.getEvent();
    this.getCategories();
  }

  getEvent() {
    // tslint:disable-next-line:prefer-const
    let id = this.route.snapshot.paramMap.get('id');
    this.eventService.getEvent(id).subscribe(
      (data) => {
        this.event = data;
      },
      (err) => {
        console.log(err);
      }
    );
  }

  getCategories() {
    this.categoryService.getCategories().subscribe(
      (data) => {
        this.categories = data;
      },
      (err) => {
        console.log(err);
      }
    );
  }

  onSubmit() {
    // tslint:disable-next-line:prefer-const
    let  newEvent = {
      'name': this.event.name,
      'description': this.event.description,
      'date': this.event.date,
      'category': this.event.category.id
    };
    this.eventService.putEvent(this.event.id, newEvent).subscribe(
      (data) => {
        alert('The event is well updated');
        this.router.navigate(['/events']);
      },
      (err) => {
        console.log(err);
      }
    );
  }
}
