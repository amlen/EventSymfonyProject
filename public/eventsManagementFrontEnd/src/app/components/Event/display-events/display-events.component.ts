import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Event } from 'src/app/classes/event';
import { EventService } from 'src/app/services/event.service';
@Component({
  selector: 'app-display-events',
  templateUrl: './display-events.component.html',
  styleUrls: ['./display-events.component.css']
})
export class DisplayEventsComponent implements OnInit {
  events: Event[];

  constructor(private eventService: EventService,
              private router: Router) { }

  ngOnInit() {
    this.getEvents();
  }

  getEvents() {
    this.eventService.getEvents().subscribe(
      (data) => {
        this.events = data;
      },
      (err) => {
        console.log(err);
      }
    );
  }

  deleteEvent(id) {
    this.eventService.deleteEvent(id).subscribe(
      (data) => {
          let i = 0;
          for (i; i < this.events.length; i++) {
            if (this.events[i].id === id) {
              this.events.splice(i, 1);
            }
          }
          alert('The event is well deleted');
          this.router.navigate(['/events']);
      },
      (err) => {
        console.log(err);
      }
    );
  }
}
